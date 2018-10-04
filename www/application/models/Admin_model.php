<?php
class Admin_model extends CI_Model
{
    public function get_all_reservations()
    {
        $result = [];

        $query = $this->db->get('reservations');

        $sql = "SELECT r.title, r.description, i.name as item_name, u.name as user_name, r.start_time, r.end_time, r.created_at, r.deleted FROM reservations as r
                INNER JOIN res_items as i ON i.id = r.res_item_id
                INNER JOIN users as u ON u.id = r.user_id;";

        $query = $this->db->query($sql, []);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function get_all_users()
    {
        $result = [];

        $sql = "SELECT u.id, u.name, u.email, u.active, u.created_at, r.name as role
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

    public function get_all_res_items()
    {
        $result = [];

        $sql = "SELECT i.id, i.name, i.description, i.res_type_id, t.name as res_type_name, i.created_at
                FROM res_items as i
                INNER JOIN res_types as t ON t.id = i.res_type_id";
        $query = $this->db->query($sql, []);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_all_res_types()
    {
        $result = [];

        $sql = "SELECT * FROM res_types";
        $query = $this->db->query($sql, []);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }
}