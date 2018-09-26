<?php
class User_model extends CI_Model
{
    public function create($data)
    {
        $result = [];
        $sql = 'INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, ?)';
        $query = $this->db->query($sql, []);
    }
}