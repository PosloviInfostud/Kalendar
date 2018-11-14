<?php
class User_model extends CI_Model
{
    public function register($by_invite = false)
    {
        $this->load->library('encryption');

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email|is_unique[users.email]|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.',
                'is_unique' => 'This %s already exists.'
            )
        );
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|trim|matches[password]');

        if ($this->form_validation->run())
        {
            $data = [
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password'),
                "by_invite" => $by_invite
            ];
            $message['user_id'] = $this->create($data);
            $message['status'] = 'success';
            $message['errors'] = 'No errors';
            $email = $this->input->post('email');
            $this->logs->user_logs($email, 1, NULL, "R");
        }
        else
        {
            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value)
            {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }
            $message['errors'] = array_filter($errors); // Some might be empty
            $message['status'] = 'form_error';

            $email = $this->input->post('email');
            $this->logs->user_logs($email, 0, $message, "R");
        }
        return $message;
    }
    public function create($data)
    {
        $activation_key = bin2hex($this->encryption->create_key(16));
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $result = [];
        $sql = 'INSERT INTO users (name, email, password, activation_key) VALUES (?, ?, ?, ?)';
        $query = $this->db->query($sql, [$data['name'], $data['email'], $password_hash, $activation_key]);
        $this->load->model('Logs_model','logs');
        $data_log = [
            'user_id' => $this->db->insert_id(),
            'table' => 'users',
            'type' => 'insert',
            'value' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password_hash
            ]
        ];
        $this->logs->insert_log($data_log);

        // Send activation email and set notification if it's a regular registration (not register by invite)
        if($data['by_invite'] === false) {
        $this->send_activation_mail($data['email'], $activation_key);
        // Set notfication
        $msg = $this->alerts->render('teal', 'Success', 'You have successfully registered. A verification link has been sent to your email account.');
        $this->session->set_flashdata('flash_message', $msg);
        }


        // user_id neccessary for register_by_invitation function in Reg_log controller
        return $data_log['user_id'];
    }

    public function send_activation_mail($email, $key)
    {
        // Prepare email
        $email_details = [];

        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'Your activation link';
        $email_details['message'] = "Click on the link below to activate your account: <b />" . user_activation_link($email, $key);

        // Add email to queue
        $this->mail->add_mail_to_queue(array($email), $email_details);
    }

    public function activate($id)
    {
        $sql = "UPDATE users SET active = 1, activation_key = '' WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        $this->load->model('Logs_model','logs');
        $data_log = [
            'user_id' => $id,
            'table' => 'users',
            'type' => 'update',
            'value' => [
                'active' => '1',
                'activation_key' => '']
        ];
        $this->logs->insert_log($data_log);

        // Set notification
        $msg = $this->alerts->render('teal', 'Account activated', 'Your account has been activated successfully. You can now login.');
        $this->session->set_flashdata('flash_message', $msg);
    }

    public function get_single_user($id)
    {
        $result = [];
        $sql = "SELECT * FROM users WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }
        return $result;
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

        // Initiate the return message
        $message = [
            'status' => 'user_error',
            'error' => ''
        ];

        if (empty($user)) {
            $message['error'] = "Please, register first!";
            $email = $data['email'];
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $message);

        } else {
            if (password_verify($data['password'], $user['password']) == false) {
                $message['error'] = "Incorrect password";
                $email = $data['email'];
                $this->load->model('Logs_model', 'logs');
                $this->logs->user_logs($email, 0, $message);

            } else {
                if ($user['active'] != 1) {
                    $message['error'] = "Please, activate your profile first!";

                    $email = $data['email'];
                    $this->load->model('Logs_model', 'logs');
                    $this->logs->user_logs($email, 0, $message);
  
                } else {
                    $name = "usr-vezba";
                    $this->load->library('encryption');
                    $value = bin2hex($this->encryption->create_key(16));
                    $expire = date('Y-m-d h:i:s', strtotime('+2 days'));
                    $this->save_login_token($user['id'], $value, $expire);
                    $cookie = array(
                        'name'   => $name,
                        'value'  => $value,
                        'expire' => '172800',
                    );

                    $this->input->set_cookie($cookie);
                    
                    $message['status'] = "success";
                    $message['error'] = "No errors.";

                    $email = $data['email'];
                    $this->load->model('Logs_model', 'logs');
                    $this->logs->user_logs($email, 1);
                }
            }
        }
        return $message;
    }

    public function save_login_token($user_id, $value, $expire)
    {
        $sql = "UPDATE users SET token = ?, token_expiration_time = ? WHERE id = ?";
        $query = $this->db->query($sql, [$value, $expire, $user_id]);

        $this->load->model('Logs_model','logs');
        $data_log = [
            'user_id' => $user_id,
            'table' => 'users',
            'type' => 'update',
            'value' => [
                'token' => $value,
                'token_expiration_time' => $expire,
            ]
        ];
        $this->logs->insert_log($data_log);
    }

    public function set_reset_key($email, $code, $expire)
    {
        $sql = "UPDATE users SET reset_key = ?, reset_key_exp = ? WHERE email = ?";
        $query = $this->db->query($sql, [$code, $expire, $email]);
        $this->load->model('Logs_model','logs');
        $data_log = [
            'user_id' => $this->get_user_by_email($email)['id'],
            'table' => 'users',
            'type' => 'update',
            'value' => [
                'reset_key' => $code,
                'reset_key_exp' => $expire
            ]
        ];
        $this->logs->insert_log($data_log);
    }

    public function check_reset_token($data)
    {
        $sql = "SELECT id FROM users WHERE email = ? AND reset_key = ?";
        $query = $this->db->query($sql, [$data['email'], $data['code']]);

        if($query->num_rows()>0) { 
            return true;
        } else {
            return false;
        }
    }
    public function reset_password($data)
    {
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $today = date('Y-m-d h:i:s');
        $sql = "UPDATE users 
                SET password = ?, 
                reset_key = NULL, 
                reset_key_exp = NULL
                WHERE email LIKE ? 
                AND reset_key LIKE ? 
                AND reset_key_exp >= ?";
        $query = $this->db->query($sql, [$password_hash, $data['email'], $data['reset_key'], $today]);

        $this->load->model('Logs_model','logs');
        $data_log = [
            'user_id' => $this->get_user_by_email($data['email'])['id'],
            'table' => 'users',
            'type' => 'update',
            'value' => [
                'password' => $password_hash,
                'reset_key' => $data['reset_key'],
                'reset_key_exp' => ''
            ]
        ];
        $this->logs->insert_log($data_log);
        return true;
    }

    public function get_all_user_roles()
    {
        $result = [];

        $sql = "SELECT * FROM user_roles";
        $query = $this->db->query($sql, []);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function update($data)
    {
        $sql = "UPDATE users SET name = ?, email = ?, user_role_id = ?, active = ? WHERE id = ?";
        $query = $this->db->query($sql, [$data['name'], $data['email'], $data['role_id'], $data['active'], $data['id']]);
    }

    public function check_invite_token($data)
    {
        $sql = "SELECT id FROM pending_users WHERE email = ? AND invite_token = ?";
        $query = $this->db->query($sql, [$data['email'], $data['token']]);

        if($query->num_rows()>0) { 
            return true;
        } else {
            return false;
        }
    }

    public function change_user_notifications($user_id, $notify, $column)
    {
        $sql = "UPDATE users SET ".$column." = ?, modified_at = NOW() WHERE id = ?";
        $query = $this->db->query($sql, [$notify, $user_id]);

        $data_log = [
            'user_id' => $user_id,
            'table' => 'users',
            'type' => 'update',
            'value' => [
                $column => $notify,
            ]
        ];
        $this->logs->insert_log($data_log);

        if ($column != "not_create") {
            $sql = "UPDATE res_members SET ".$column." = ?, modified_at = NOW() WHERE user_id = ?";
            $query = $this->db->query($sql, [$notify, $user_id]);
    
            $data_log = [
                'user_id' => $user_id,
                'table' => 'res_members',
                'type' => 'update',
                'value' => [
                    $column => $notify,
                ]
            ];
            $this->logs->insert_log($data_log);       
        }
    }

}