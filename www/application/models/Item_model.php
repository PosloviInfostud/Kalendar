<?php
class Item_model extends CI_Model
{
    public function insert($data)
    {
        $sql = 'INSERT INTO res_items (res_type_id, name, description) VALUES (?, ?, ?)';
        $query = $this->db->query($sql, [$data['type'], $data['name'], $data['description']]);
    }

    public function update($data)
    {
        $sql = "UPDATE res_items SET res_type_id = ?, name = ?, description = ? WHERE id = ?";
        $query = $this->db->query($sql, [$data['type'], $data['name'], $data['description'], $data['id']]);
    }

    public function get_single_item($id)
    {
        $result = [];
        $sql = "SELECT * FROM res_items WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }

        return $result;
    }

    public function get_all_item_types()
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