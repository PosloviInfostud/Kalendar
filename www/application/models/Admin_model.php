<?php
class Admin_model extends CI_Model
{
    public function get_all_room_reservations()
    {
        $result = [];

        $sql = "SELECT r.title, 
                r.description, 
                u.name as user_name, 
                r.start_time, 
                r.end_time, 
                r.created_at, 
                r.deleted 
                FROM room_reservations as r
                INNER JOIN users as u ON u.id = r.user_id;";

        $query = $this->db->query($sql, []);

        if ($query->num_rows()) {
            $result = $this->beautify->room_reservations_view_data($query->result_array());
        }

        return $result;
    }

    public function get_all_equipment_reservations()
    {
        $result = [];

        $sql = "SELECT r.description, 
                u.name as user_name, 
                r.start_time, 
                r.end_time, 
                r.created_at, 
                r.deleted 
                FROM equipment_reservations as r
                INNER JOIN users as u ON u.id = r.user_id;";

        $query = $this->db->query($sql, []);

        if ($query->num_rows()) {
            $result = $this->beautify->equipment_reservations_view_data($query->result_array());
        }

        return $result;
    }

    public function get_all_rooms()
    {
        $result = [];

        $sql = "SELECT id, name, description, capacity FROM rooms";

        $query = $this->db->query($sql, []);

        if ($query->num_rows()) {
            $result = $this->beautify->preview_description($query->result_array());
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

        $sql = "SELECT u.email as user_email, l.altered_table, l.type, l.value, l.created_at FROM logs as l
                INNER JOIN users as u ON u.id = l.user_id;";

        $query = $this->db->query($sql, []);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function get_all_equipment()
    {
        $result = [];

        $sql = "SELECT e.id, e.name, e.barcode, e.description, e.equipment_type_id, t.name as equipment_type_name, e.created_at
                FROM equipment as e
                INNER JOIN equipment_types as t ON t.id = e.equipment_type_id";
        $query = $this->db->query($sql, []);
        if ($query->num_rows()) {
            $result = $this->beautify->preview_description($query->result_array());
        }
        return $result;
    }

    public function get_all_equipment_types()
    {
        $result = [];

        $sql = "SELECT * FROM equipment_types";
        $query = $this->db->query($sql, []);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }
}