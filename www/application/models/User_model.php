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
    }
    public function send_activation_mail($email, $key)
    {
        // Set SMTP Configuration
        $emailConfig = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'alacanatila@gmail.com',
            'smtp_pass' => 'Number!00G!',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        ];
        // Set your email information
        $from = [
            'email' => 'alacanatila@gmail.com',
            'name' => 'Atila | Vezba-Token'
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
    public function login($data)
    {
        $user = $this->get_user_by_email($data['email']);

        if (empty($user)) {
            $message = "Please, register first!";

        } else {
            if (password_verify($data['password'], $user['password']) == false) {
                $message = "Incorrect password";

            } else {
                if ($user['active'] != 1) {
                    $message = "Please, activate yuor profile first!";

                } else {
                    $this->load->helper('cookie');
                    $name = "usr-vezba";
                    $this->load->library('encryption');
                    $value = bin2hex($this->encryption->create_key(16));
                    $expire = date('Y-m-d h:i:s', strtotime('+5 days'));
                    $this->generate_login_token($user['id'], $value, $expire);
                    set_cookie($name, $value, $expire);

                    $message = "Logged in successfully!";
                }
            }
        }
        return $message;
    }

    public function generate_login_token($user_id, $value, $expire)
    {
        $sql = "UPDATE users SET token = ?, expiration_time = ? WHERE id = ?";
        $query = $this->db->query($sql, [$value, $expire, $user_id]);
    }
}