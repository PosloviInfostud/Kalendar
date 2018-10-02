<?php
class Admin_model extends CI_Model
{
    public function get_all_reservations()
    {
        $result = [];

        $query = $this->db->get('reservations');
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_all_users()
    {
        $result = [];

        $sql = "SELECT u.name, u.email, u.active, u.created_at, r.name as role
                FROM users as u
                INNER JOIN user_roles as r ON r.id = u.user_role_id";
        $query = $this->db->query($sql, []);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_all_user_activities()
    {
        $result = [];

        $query = $this->db->get('user_logs');
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_all_logs()
    {
        $result = [];

        $query = $this->db->get('logs');
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }
}