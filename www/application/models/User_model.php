<?php

class User_model extends CI_Models
{
    public function get_user_by_email($email)
    {
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

        if (password_verify($data['password'], $user['password']) == FALSE) {

        } else {
            
        }
    }
}