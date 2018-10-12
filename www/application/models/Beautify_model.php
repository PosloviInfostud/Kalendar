<?php
class Beautify_model extends CI_Model
{
    public function user_meetings_view_data($data)
    {
        $result = array();
        foreach($data as $key => $value) {
            $result[$key] = $value;
            $result[$key]['start_time'] = date('D @ H:i (d/m/y)', strtotime($value['start_time']));
            $result[$key]['end_time'] = date('D @ H:i (d/m/y)', strtotime($value['start_time']));
            $result[$key]['created_at'] = date('D @ H:i (d/m/y)', strtotime($value['start_time']));
            $result[$key]['description'] = ucfirst($value['description']);
            if (strtotime($value['start_time']) < time()) {
                $result[$key]['status'] = 'ongoing';
            } else {
                $result[$key]['status'] = 'upcoming';
            };
        }
        return $result;
    }

    public function user_equipment_view_data($data)
    {
        $result = array();
        foreach($data as $key => $value) {
            $result[$key] = $value;
            $result[$key]['start_time'] = date('D @ H:i (d/m/y)', strtotime($value['start_time']));
            $result[$key]['end_time'] = date('D @ H:i (d/m/y)', strtotime($value['end_time']));
            $result[$key]['full_description'] = ucfirst($value['description']);
            $result[$key]['description'] = substr(ucfirst($value['description']), 0, 120);
            if (strtotime($value['start_time']) < time()) {
                $result[$key]['status'] = 'Active';
            } else {
                $result[$key]['status'] = 'Expired';
            };
        }
        return $result;
    }

    public function room_reservations_view_data($data)
    {
        $result = array();
        foreach($data as $key => $value) {
            $result[$key] = $value;
            $result[$key]['start_time'] = date('D @ H:i (d/m/y)', strtotime($value['start_time']));
            $result[$key]['end_time'] = date('D @ H:i (d/m/y)', strtotime($value['end_time']));
            $result[$key]['created_at'] = date('D @ H:i (d/m/y)', strtotime($value['end_time']));
            $result[$key]['description'] = substr(ucfirst($value['description']), 0, 120);
            $result[$key]['user_name'] = ucwords($value['user_name']);
        }
        return $result;
    }

    public function equipment_reservations_view_data($data)
    {
        $result = array();
        foreach($data as $key => $value) {
            $result[$key] = $value;
            $result[$key]['start_time'] = date('D @ H:i (d/m/y)', strtotime($value['start_time']));
            $result[$key]['end_time'] = date('D @ H:i (d/m/y)', strtotime($value['end_time']));
            $result[$key]['created_at'] = date('D @ H:i (d/m/y)', strtotime($value['end_time']));
            $result[$key]['description'] = substr(ucfirst($value['description']), 0, 120);
            $result[$key]['user_name'] = ucwords($value['user_name']);
        }
        return $result;
    }

    public function preview_description($data)
    {
        $result = array();
        foreach($data as $key => $value) {
            $result[$key] = $value;
            $result[$key]['description'] = substr(ucfirst($value['description']), 0, 120);
        }
        return $result;
    }
}