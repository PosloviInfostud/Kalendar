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
        $query = $this->db->query($sql, [$email, $log_type, $success, $log_desc, $ip, $browser]);
    }

    public function insert_logs($sql, $values, $update_columns = NULL)
    {
        $cookie = $this->input->cookie('usr-vezba');
        $user_id = $this->get_user_by_token($cookie);
        $sql_arr = explode(' ', $sql);
        $type = $sql_arr[0]; //log type is the first word of $sql string

        //case INSERT

        if ($type == "INSERT") {

            $table = $sql_arr[2]; //table name is the 3rd word: "INSERT INTO reservations"
            
            //column names inside first brackets in $sql
            $start  = strpos($sql, '(');
            $end    = strpos($sql, ')');
            $length = $end - $start;
            $result = substr($sql, $start + 1, $length - 1);
            $result_arr = explode(',',$result);

            //creating $value
            for ($i = 0; $i< count($result_arr); $i++) {
                $value_arr[] = $result_arr[$i]." = ".$values[$i];
            }
            $value = implode(",", $value_arr);
        }

        //case UPDATE

        elseif ($type == "UPDATE") {

            $table = $sql_arr[1]; //table name is the 2nd word: "UPDATE reservations..."
            $update_columns_arr = explode(',', $update_columns);
            foreach($update_columns_arr as $update_column){
                rtrim($update_column, '?');
            }
            for ($i = 0; $i<count($update_columns_arr); $i++) {
                $value_arr[] = $update_columns_arr[$i].$values[$i];
            }
            $value = implode(",", $value_arr);
        } 
        
        //case DELETE

        elseif ($type == "DELETE") {

            $table = $sql_arr[2]; //table name is the 3rd word: "DELETE FROM reservations"

        }

        $sql_log = "INSERT INTO logs (user_id, altered_table, type, value) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql, [$user_id, $table, $type, $value]);
    }
}