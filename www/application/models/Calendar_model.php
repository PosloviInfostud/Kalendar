<?php

class Calendar_model extends CI_model {

    public function get_all_meetings_for_user($id)
    {
        $sql = "SELECT res.id, rooms.name, res.room_id, res.start_time, res.end_time, res.title FROM room_reservations AS res 
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
            $event->title = $row['title'];
            $event->room = $row['name'];
            $json_arr[] = $event;
        }

        $json = json_encode($json_arr, JSON_PRETTY_PRINT);
        echo $json;
    }

    
    public function get_all_meetings_for_room($id) {
        $sql = "SELECT id, start_time, end_time, title, description FROM room_reservations 
                WHERE (recurring = 0 OR parent != 0) AND deleted = '0' AND room_id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        $json_arr = [];
        foreach($result as $row) {
            $event['id'] = $row['id'];
            $event['start'] = $row['start_time'];
            $event['end'] = $row['end_time'];
            $event['title'] = $row['title'];
            $event['description'] = $row['description'];
            $json_arr[] = $event;
        }
        $return =  json_encode($json_arr, true);
        return $return;
    }

}