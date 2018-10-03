<?php

class User_model extends CI_Model
{
    public function create($data)
    {
        $activation_key = bin2hex($this->encryption->create_key(16));
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $result = [];
        $sql = 'INSERT INTO users (name, email, password, activation_key) VALUES (?, ?, ?, ?)';
        $query = $this->db->query($sql, [$data['name'], $data['email'], $password_hash, $activation_key]);
        $this->send_activation_mail($data['email'], $activation_key);

        $session_data = [
            'message' => 'Success! Please check your e-mail for the activation link.'
        ];

        $this->session->set_userdata($session_data);
    }

    public function send_activation_mail($email, $key)
    {
        // Set SMTP Configuration
        $emailConfig = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'visnjamarica@gmail.com',
            'smtp_pass' => '!v1snj4V1SNJ1C1C4!',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        ];
        // Set your email information
        $from = [
            'email' => 'visnjamarica@gmail.com',
            'name' => 'Visnja | Vezba-Token'
        ];
        $to = array($email);
        $subject = 'Your activation link';
        //  $message = 'Type your gmail message here'; // use this line to send text email.
        // load view file called "welcome_message" in to a $message variable as a html string.
        $message = "Click on the link below to activate your account: <b />" . user_activation_link($email, $key);
        // Load CodeIgniter Email library
        $this->load->library('email', $emailConfig);
        // Sometimes you have to set the new line character for better result
        $this->email->set_newline("\r\n");
        // Set email preferences
        $this->email->from($from['email'], $from['name']);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        // Ready to send email and check whether the email was successfully sent
        if (!$this->email->send()) {
            // Raise error message
            show_error($this->email->print_debugger());
        } else {
            // Show success notification or other things here
            // echo 'Success to send email';
        }
    }

    public function activate_user($id)
    {
        $sql = "UPDATE users SET active = 1, activation_key = '' WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        $session_data = [
            'message' => 'Success! Account activated.'
        ];

        $this->session->set_userdata($session_data);
    }

    public function get_user_by_email($email)
    {
        $result = [];
        $sql = "SELECT * FROM users WHERE email = ?";
        $query = $this->db->query($sql, [$email]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }

        return $result;
    }

    public function get_user_by_token($cookie)
    {
        $result = [];
        $sql = "SELECT * FROM users WHERE token = ?";
        $query = $this->db->query($sql, [$cookie]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }

        return $result;
    }
 
    public function login($data)
    {
        $user = $this->get_user_by_email($data['email']);

        if (empty($user)) {
            $message = "Please, register first!";

            $email = $data['email'];
            $log_desc = "not registered";
            $this->load->model('User_model', 'user');
            $this->user->user_logs($email, 0, $log_desc);


        } else {
            if (password_verify($data['password'], $user['password']) == false) {
                $message = "Incorrect password";

                $email = $data['email'];
                $log_desc = "wrong password";
                $this->load->model('User_model', 'user');
                $this->user->user_logs($email, 0, $log_desc);

            } else {
                if ($user['active'] != 1) {
                    $message = "Please, activate your profile first!";

                    $email = $data['email'];
                    $log_desc = "profile not yet activated";
                    $this->load->model('User_model', 'user');
                    $this->user->user_logs($email, 0, $log_desc);
  
                } else {
                    $this->load->helper('cookie');
                    $this->load->library('session');
                    $name = "usr-vezba";
                    $this->load->library('encryption');
                    $value = bin2hex($this->encryption->create_key(16));
                    $expire = date('Y-m-d h:i:s', strtotime('+2 days'));
                    $this->save_login_token($user['id'], $value, $expire);
                    $cookie= array(
                        'name'   => $name,
                        'value'  => $value,
                        'expire' => '172800',
                    );
                    
                    $this->input->set_cookie($cookie);
                    $session_data = [
                        $value => $user['name']
                    ];
                    $this->session->set_userdata($session_data);
                    $message = "success";

                    $email = $data['email'];
                    $this->load->model('User_model', 'user');
                    $this->user->user_logs($email, 1);

                }
            }
        }
        return $message;
    }

    public function save_login_token($user_id, $value, $expire)
    {
        $sql = "UPDATE users SET token = ?, token_expiration_time = ? WHERE id = ?";
        $query = $this->db->query($sql, [$value, $expire, $user_id]);
    }

    public function set_reset_key($email, $code, $expire)
    {
        $sql = "UPDATE users SET reset_key = ?, reset_key_exp = ? WHERE email = ?";
        $query = $this->db->query($sql, [$code, $expire, $email]);
    }

    public function reset_password($data)
    {
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $today = date('Y-m-d h:i:s');
        $sql = "UPDATE users 
                SET password = ?, reset_key = '', reset_key_exp = ''
                WHERE email LIKE ? AND reset_key LIKE ? AND reset_key_exp >= ? ";
        $query = $this->db->query($sql, [$password_hash, $data['email'], $data['reset_key'], $today]);

        if($this->db->affected_rows() >0) {
            return true;
        } else {
            return false;
        }

    }

    public function user_logs($email, $success, $log_desc = NULL, $log_type = "L")
    {
        // $ip = isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $sql = "INSERT INTO user_logs 
                (email, log_type, success, log_description, ip_address, user_agent) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, [$email, $log_type, $success, $log_desc, $ip, $browser]);
    }

    public function logs($sql, $values)
    {
        $cookie = $this->input->cookie('usr-vezba');
        $user_id = $this->get_user_by_token($cookie);
        $sql_arr = explode(' ', $sql);
        $type = $sql_arr[0]; //log type is the first word of $sql string

        //case INSERT

        if ($type == "INSERT") {

            $table = $sql_arr[2]; //table name is the 3rd word: "INSERT INTO reservations"
            
            //column names inside first brackets in $sql
            $start  = strpos($sql, '(');
            $end    = strpos($sql, ')');
            $length = $end - $start;
            $result = substr($sql, $start + 1, $length - 1);
            $result_arr = explode(',',$result);

            //creating $value
            for ($i = 0; $i< count($result_arr); $i++) {
                $value_arr[] = $result_arr[$i]." = ".$values[$i];
            }
            $value = implode(",", $value_arr);
        }

        //case UPDATE

        elseif ($type == "UPDATE") {

            $table = $sql_arr[1]; //table name is the 2nd word: "UPDATE reservations..."

        } 
        
        //case DELETE

        elseif ($type == "DELETE") {

            $table = $sql_arr[2]; //table name is the 3rd word: "DELETE FROM reservations"

        }

        $sql_log = "INSERT INTO logs (user_id, altered_table, type, value) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql, [$user_id, $table, $type, $value]);
    }
}