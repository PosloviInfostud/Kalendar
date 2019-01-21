<?php

class Logs_model extends CI_Model
{

    public function user_logs($email, $success, $log_desc = NULL, $log_type = "L")
    {
        // $ip = isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $sql = "INSERT INTO user_logs 
                (email, log_type, success, log_description, ip_address, user_agent) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, [$email, $log_type, $success, json_encode($log_desc), $ip, $browser]);
    }

    public function insert_log($data_log)
    {
        $sql_log = "INSERT INTO logs (user_id, altered_table, type, value) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql_log, [$data_log['user_id'], $data_log['table'], $data_log['type'], json_encode($data_log['value'])]);
    }
}