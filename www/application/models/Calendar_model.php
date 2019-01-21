<?php

class Calendar_model extends CI_model {

    public function get_all_meetings_for_user($id)
    {
        $result = [];
        $sql = "SELECT res.id, rooms.name, rooms.color, res.room_id, res.start_time, res.end_time, res.title FROM room_reservations AS res 
                INNER JOIN res_members AS mem ON mem.res_id = res.id 
                INNER JOIN rooms ON rooms.id = res.room_id
                WHERE mem.user_id = ? 
                AND (res.recurring = '0' OR res.parent != '0') 
                AND res.deleted = '0'";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
        }
        $json_arr = [];
        foreach($result as $row) {
            $event = (object)[];
            $event->id = $row['id'];
            $event->start = $row['start_time'];
            $event->end = $row['end_time'];
            $event->title = $row['name'].": ".$row['title'];
            $event->room = $row['name'];
            $event->color = $row['color'];
            $json_arr[] = $event;
        }

        $json = json_encode($json_arr, JSON_PRETTY_PRINT);
        return $json;
    }

    public function get_all_items_for_user($id)
    {
        $result = [];
        $sql = "SELECT  res.id, 
                        res.equipment_id, 
                        res.start_time, 
                        res.end_time, 
                        res.description AS reason, 
                        equipment.barcode,
                        equipment.name,
                        equipment.description,
                        types.name AS type,
                        types.color
                FROM equipment_reservations AS res 
                INNER JOIN equipment ON res.equipment_id = equipment.id 
                INNER JOIN equipment_types AS types ON types.id = equipment.equipment_type_id 
                WHERE res.user_id = ?
                AND res.deleted = '0'";
        $query = $this->db->query($sql, [$id]);
        
        if($query->num_rows()) {
            $result = $query->result_array();
        }
        $json_arr = [];
        foreach($result as $row) {
            $item = (object)[];
            $item->id = $row['id'];
            $item->start = $row['start_time'];
            $item->end = $row['end_time'];
            $item->type = $row['type'];
            $item->title = $row['type']." ".$row['name'];
            $item->desc = $row['reason'];
            $item->color = $row['color'];
            $json_arr[] = $item;
        }

        $json = json_encode($json_arr, JSON_PRETTY_PRINT);
        return $json;
    }
    
    public function get_all_meetings_for_room($id) {
        $result = [];
        $sql = "SELECT  res.id, 
                        res.start_time, 
                        res.end_time, 
                        res.title, 
                        res.description,
                        users.name AS creator
                FROM room_reservations AS res 
                INNER JOIN users ON users.id = res.user_id
                WHERE (recurring = 0 OR parent != 0) AND deleted = '0' AND room_id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        $color = $this->room_color($id);
        $json_arr = [];
        foreach($result as $row) {
            $event['id'] = $row['id'];
            $event['start'] = $row['start_time'];
            $event['end'] = $row['end_time'];
            $event['title'] = $row['title']." (by ".$row['creator'].")";
            $event['description'] = $row['description'];
            $event['color'] = $color;
            $json_arr[] = $event;
        }
        $return =  json_encode($json_arr, true);
        return $return;
    }

    public function room_color($id)
    {
        $color = "#4dc0b5";
        $sql = "SELECT color FROM rooms WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()){
            $result = $query->row_array();
        }
        $color = $result['color'];
        return $color;
    }

    public function get_all_item_reservations($id) {
        $result = [];
        $sql = "SELECT id, start_time, end_time, description FROM equipment_reservations 
                WHERE deleted = '0' AND equipment_id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        $json_arr = [];
        foreach($result as $row) {
            $event['id'] = $row['id'];
            $event['start'] = $row['start_time'];
            $event['end'] = $row['end_time'];
            $event['description'] = $row['description'];
            $json_arr[] = $event;
        }
        $return =  json_encode($json_arr, true);
        return $return;
    }

}