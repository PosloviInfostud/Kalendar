<?php

class User_model extends CI_Model
{
    public function register()
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

        $message = [];

        if ($this->form_validation->run() == false) {
            $message['error'] = validation_errors();
            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $message, "R");

        } else {
            $data = [
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password')
            ];
            $message['user_id'] = $this->create($data);
            $message['success'] = 'success';
            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 1, NULL, "R");

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
        $this->send_activation_mail($data['email'], $activation_key);

        $this->session->set_flashdata('flash_message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Success! Please check your e-mail for the activation link.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        // user_id neccessary for register_by_invitation function in Reg_log controller
        return $data_log['user_id'];
    }

    public function send_activation_mail($email, $key)
    {
        // Prepare email
        $email_details = [];

        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'Your activation link';
        $email_details['message'] = $message = "Click on the link below to activate your account: <b />" . user_activation_link($email, $key);

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

        $this->session->set_flashdata('flash_message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Success! Account activated.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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

        if (empty($user)) {
            $message = "Please, register first!";

            $email = $data['email'];
            $log_desc = "not registered";
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $log_desc);


        } else {
            if (password_verify($data['password'], $user['password']) == false) {
                $message = "Incorrect password";

                $email = $data['email'];
                $log_desc = "wrong password";
                $this->load->model('Logs_model', 'logs');
                $this->logs->user_logs($email, 0, $log_desc);

            } else {
                if ($user['active'] != 1) {
                    $message = "Please, activate your profile first!";

                    $email = $data['email'];
                    $log_desc = "profile not yet activated";
                    $this->load->model('Logs_model', 'logs');
                    $this->logs->user_logs($email, 0, $log_desc);
  
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
                SET password = ?, reset_key = '', reset_key_exp = ''
                WHERE email LIKE ? AND reset_key LIKE ? AND reset_key_exp >= ?";
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

}