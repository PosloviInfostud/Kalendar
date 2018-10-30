<?php

class Calendar_model extends CI_model {

    public function get_all_meetings_for_user($id)
    {
        $sql = "SELECT res.id, rooms.name, res.room_id, res.start_time, res.end_time, res.title FROM room_reservations AS res 
                INNER JOIN res_members AS mem ON mem.res_id = res.id 
                INNER JOIN rooms ON rooms.id = res.room_id
                WHERE mem.user_id = ? 
                AND (res.recurring = '0' OR res.parent != '0')";
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
            $json_arr[] = $event;
        }

        $json = json_encode($json_arr, JSON_PRETTY_PRINT);
        echo $json;


    }
}