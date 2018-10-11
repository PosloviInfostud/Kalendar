<?php
class Item_model extends CI_Model
{

    /* CONFERENCE ROOMS */
    public function insert_room($data)
    {
        $sql = 'INSERT INTO rooms (name, description, capacity) VALUES (?, ?, ?)';
        $query = $this->db->query($sql, [$data['name'], $data['description'], $data['capacity']]);
    }

    public function update_room($data)
    {
        $sql = "UPDATE rooms SET name = ?, description = ?, capacity = ? WHERE id = ?";
        $query = $this->db->query($sql, [$data['name'], $data['description'], $data['capacity'], $data['id']]);
    }

    public function get_single_room($id)
    {
        $result = [];
        $sql = "SELECT * FROM rooms WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }

        return $result;
    }

    /* EQUIPMENT */

    public function insert_equipment($data)
    {
        $sql = 'INSERT INTO equipment (equipment_type_id, barcode, name, description) VALUES (?, ?, ?, ?)';
        $query = $this->db->query($sql, [$data['type'], $data['barcode'], $data['name'], $data['description']]);
    }

    public function update_equipment($data)
    {
        $sql = "UPDATE equipment SET name = ?, description = ?, barcode = ?, equipment_type_id = ? WHERE id = ?";
        $query = $this->db->query($sql, [$data['name'], $data['description'], $data['barcode'], $data['type'], $data['id']]);
    }

    public function get_single_equipment($id)
    {
        $result = [];
        $sql = "SELECT * FROM equipment WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }

        return $result;
    }

        /* EQUIPMENT */

        public function insert_type($data)
        {
            $sql = 'INSERT INTO equipment_types (name) VALUES (?)';
            $query = $this->db->query($sql, [$data['name']]);
        }
    
        public function update_type($data)
        {
            $sql = "UPDATE equipment_types SET name = ? WHERE id = ?";
            $query = $this->db->query($sql, [$data['name'], $data['id']]);
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

    public function get_single_equipment_type($id)
    {
        $result = [];
        $sql = "SELECT * FROM equipment_types WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }

        return $result;
    }
}