<?php

class User_model extends CI_Model
{
    public function create($data)
    {
        $result = [];
        $sql = 'INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, ?)';
        $query = $this->db->query($sql, []);
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
            if (password_verify($data['password'], $user['password']) == FALSE) {
                $message = "Incorrect password";

            } else {
                if ($user['active']!=1) {
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