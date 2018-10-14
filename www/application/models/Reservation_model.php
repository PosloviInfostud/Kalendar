<?php
class Reservation_model extends CI_Model
{
    public function invite_members($res_id)
    {
        $result = [];
        $sql = 'SELECT users.name, users.email, room_reservations.start_time, room_reservations.end_time, room_reservations.title, room_reservations.description
         FROM res_members 
         INNER JOIN users ON users.id = res_members.user_id 
         INNER JOIN room_reservations ON room_reservations.id = res_members.res_id 
         INNER JOIN rooms ON room_reservations.room_id = rooms.id
         WHERE res_members.res_role_id = 2 AND res_members.res_id = ?';
        $query = $this->db->query($sql, [$res_id]);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        foreach ($result as $user) {
            $this->send_members_notification($user);
        }
    }
    public function send_members_notification($user)
    {
        $email = $user['email'];
        // Set SMTP Configuration
        $emailConfig = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'visnjamarica@gmail.com',
            'smtp_pass' => '!v1snj4V1SNJ1C1C4!',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        ];
        // Set your email information
        $from = [
            'email' => 'visnjamarica@gmail.com',
            'name' => 'Visnja | Vezba-Token'
        ];
        $to = array($email);
        $subject = 'New meeting';
        $message = $this->load->view('reservation_invitation_mail', $user, true);

        // Load CodeIgniter Email library
        $this->load->library('email', $emailConfig);
        // Sometimes you have to set the new line character for better result
        $this->email->set_newline("\r\n");
        // Set email preferences
        $this->email->from($from['email'], $from['name']);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        // Ready to send email and check whether the email was successfully sent
        if (!$this->email->send()) {
            // Raise error message
            show_error($this->email->print_debugger());
        } else {
            // Show success notification or other things here
            // echo 'Success to send email';
        }
    }

    public function check_free_rooms($data)
    {
        $reserved_arr = [];
        $free = [];
        $sql = "SELECT rooms.id FROM rooms 
                INNER JOIN room_reservations ON rooms.id = room_reservations.room_id 
                WHERE (room_reservations.start_time < ? AND room_reservations.end_time > ?) OR (room_reservations.start_time < ? AND room_reservations.start_time >= ?) 
                GROUP BY room_id";
        $query = $this->db->query($sql, [$data['start_time'], $data['start_time'], $data['end_time'], $data['start_time']]);
            
            if($query->num_rows()) {
                $result = $query->result_array();
            } else {
                $result = [];
            }
            foreach ($result as $row) {
                $reserved_arr[] = $row['id'];
            }
        $reserved = implode(",", $reserved_arr);

        if ($reserved == "") {
            $sql = "SELECT id, name FROM rooms WHERE capacity > ?";
            $query = $this->db->query($sql,[$data['attendants']]);

            if($query->num_rows()) {
            $free = $query->result_array();
            }
            
        } else {
            $sql = "SELECT id, name FROM rooms 
            WHERE id NOT IN (".$reserved.")  
            AND capacity > ?";
            $query = $this->db->query($sql,[$data['attendants']]);

            if($query->num_rows()) {
            $free = $query->result_array();
            }
        }

        return $free;
    }

    public function show_users_for_invitation()
    {
        $cookie = $this->user_data['token'];
        $admin = $this->user_data['user']['id'];

        $sql = "SELECT id, name, email FROM users WHERE id != ?";
        $query = $this->db->query($sql, [$admin]);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }

        return $result;

    }
    public function check_if_room_is_free($data)
    {
        $sql = "SELECT COUNT(*) AS reserved FROM room_reservations 
                WHERE ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?)) 
                AND room_id = ? "; 
        $query = $this->db->query($sql,[$data['start_time'], $data['start_time'], $data['end_time'], $data['start_time'], $data['room']]);

        if($query->num_rows()) {
            $result = $query->row_array();
        }
        if ($result['reserved'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_if_equipment_is_free($data)
    {  
        $sql = "SELECT COUNT(*) AS reserved FROM equipment_reservations 
                WHERE 
                ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?))
                AND
                 equipment_id = ? ";
        $query = $this->db->query($sql, [$data['start_time'], $data['start_time'], $data['end_time'], $data['start_time'], $data['equipment_id']]);
        if($query->num_rows()) {
            $result = $query->row_array();
        }
        if ($result['reserved'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function submit_reservation_form($data)
    {
        $user_id = $this->user_data['user']['id'];

        $sql = "INSERT INTO room_reservations  
                (room_id, user_id, start_time, end_time, title, description) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $query = $this->db->query($sql, [$data['room'], $user_id, $data['start_time'], $data['end_time'], $data['title'], $data['description']]);

        $data['res_id'] = $this->db->insert_id();
        $data['admin'] = $user_id;

        $this->load->model('Logs_model', 'logs');
        $data_log = [
            'user_id' => $user_id,
            'table' => 'room_reservations',
            'type' => 'insert',
            'value' => [
                'room_id' => $data['room'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'title' => $data['title'],
                'description' => $data['description']
            ]
        ];
        $this->logs->insert_log($data_log);
        $this->session->set_flashdata('flash_message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Success! Your reservation has been created!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        $this->insert_reservation_members($data);
        $this->insert_creator_into_res_members($data['res_id'], $user_id);
    }

    public function insert_reservation_members($data)
    {   
        $res_id = $data['res_id'];
        $user_id = $data['admin'];
        foreach ($data['members'] as $member) {
            $sql = "INSERT INTO res_members 
                    (res_id, user_id) 
                    VALUES (?, ?)";
            $query = $this->db->query($sql, [$res_id, $member]);
            $data_log = [
                'user_id' => $user_id,
                'table' => 'res_members',
                'type' => 'insert',
                'value' => [
                    'res_id' => $res_id,
                    'member' => $member
                ]
            ];
            $this->logs->insert_log($data_log);
        }
    }

    public function insert_creator_into_res_members($res_id, $user_id)
    {
        $sql = "INSERT INTO res_members 
        (res_id, user_id, res_role_id) 
        VALUES (?, ?, ?)";
        $query = $this->db->query($sql, [$res_id, $user_id, 1]);
        $data_log = [
            'user_id' => $user_id,
            'table' => 'res_members',
            'type' => 'insert',
            'value' => [
                'res_id' => $res_id,
                'member' => $user_id,
                'role_id' => 1
            ]
        ];
        $this->logs->insert_log($data_log);
    }

    public function get_all_equipment()
    {
        $sql = "SELECT id, name FROM equipment_types";
        $query = $this->db->query($sql);

        if ($query->num_rows()) {
            $result = $query->result_array();
        } else {
            $result = [];
        }

        return $result;
    }

    public function search_free_equipment($data)
    {   
        $reserved_arr = [];
        $free = [];
        $sql = "SELECT equipment.id AS id FROM equipment 
                INNER JOIN equipment_reservations ON equipment.id = equipment_reservations.equipment_id  
                WHERE (equipment_reservations.start_time < ? AND equipment_reservations.end_time > ?) OR (equipment_reservations.start_time < ? AND equipment_reservations.start_time >= ?) 
                AND equipment_type_id = ? 
                GROUP BY equipment_id";
        $query = $this->db->query($sql, [$data['start_time'], $data['start_time'], $data['end_time'], $data['start_time'], $data['type']]);
        
        if($query->num_rows()) {
            $result = $query->result_array();
        } else {
            $result = [];
        }
        foreach ($result as $row) {
            $reserved_arr[] = $row['id'];
        }
    $reserved = implode(",", $reserved_arr); 

    if ($reserved == "") {
        $sql = "SELECT id, barcode, name, description FROM  equipment 
                WHERE equipment_type_id = ? ";
        $query = $this->db->query($sql, [$data['type']]);

        if($query->num_rows()) {
            $free = $query->result_array();
        }
    } 
    else {
        $sql = "SELECT id, barcode, name, description FROM  equipment 
                WHERE id NOT IN (".$reserved.") 
                AND equipment_type_id = ? ";
        $query = $this->db->query($sql, [$data['type']]);

        if($query->num_rows()) {
            $free = $query->result_array();
        }
    }
    return $free;
    }

    public function submit_reservation_equip_form($data)
    {
        $user_id = $this->user_data['user']['id'];

        $sql = "INSERT INTO equipment_reservations  
                (equipment_id, user_id, start_time, end_time, description) 
                VALUES (?, ?, ?, ?, ?)";

        $query = $this->db->query($sql, [$data['equipment_id'], $user_id, $data['start_time'], $data['end_time'], $data['description']]);

        $this->load->model('Logs_model', 'logs');
         $data_log = [
            'user_id' => $user_id,
            'table' => 'equipment_reservations',
            'type' => 'insert',
            'value' => [
                'equipment_id' => $data['equipment_id'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'description' => $data['description']
            ]
        ];
        $this->logs->insert_log($data_log);

        $this->session->set_flashdata('flash_message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Success! Your reservation has been created!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function room_reservations_by_user($id)
    {
        $result = [];
        $sql = 'SELECT mem.res_id,
         mem.user_id, mem.res_role_id, 
         res.room_id, room.name as room_name, 
         res.user_id as creator_id, u.name as created_by, 
         res.title,
          res.description, 
         res.start_time, 
         res.end_time
          FROM res_members as mem
                INNER JOIN room_reservations as res ON res.id = mem.res_id
                INNER JOIN users as u ON res.user_id = u.id
                INNER JOIN rooms as room ON room.id = res.room_id
                WHERE mem.user_id = ? AND res.end_time >= NOW()
                ORDER BY res.start_time ASC';
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_meetings_view_data($query->result_array());
            return $result;
        }
    }

    public function single_room_reservation($id)
    {
        $result = [];
        $sql = 'SELECT res.id, 
                res.user_id AS creator_id, 
                u.name AS creator_name, 
                res.start_time, 
                res.end_time, 
                res.created_at, 
                res.room_id, 
                room.name, 
                res.title, 
                res.description 
                FROM room_reservations AS res
                INNER JOIN users as u ON res.user_id = u.id
                INNER JOIN rooms as room ON room.id = res.room_id
                WHERE res.id = ?';
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_meetings_view_data($query->result_array());
            return $result;
        }
    }

    public function equipment_reservations_by_user($id)
    {
        $result = [];
        $sql = 'SELECT res.id, 
                res.equipment_id, 
                res.start_time, 
                res.end_time, 
                res.description, 
                e.name as item_name, 
                type.name as item_type 
                FROM equipment_reservations as res
                INNER JOIN equipment as e ON e.id = res.equipment_id
                INNER JOIN equipment_types as type ON type.id = e.equipment_type_id
                WHERE res.user_id IN ?';
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_equipment_view_data($query->result_array());
            return $result;
        }
    }

    public function single_equipment_reservation($id)
    {
        $result = [];
        $sql = 'SELECT res.id, 
                res.equipment_id, 
                res.start_time, 
                res.end_time, 
                res.description, 
                res.user_id, 
                e.name as item_name, 
                type.name as item_type 
                FROM equipment_reservations as res
                INNER JOIN equipment as e ON e.id = res.equipment_id
                INNER JOIN equipment_types as type ON type.id = e.equipment_type_id
                WHERE res.id = ?';
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_equipment_view_data($query->result_array());
            return $result;
        }
    }

    public function get_reservation_members($id)
    {
        $result = [];
        $sql = 'SELECT mem.user_id, mem.res_role_id, u.name, u.email FROM res_members AS mem
                INNER JOIN users AS u ON u.id = mem.user_id
                WHERE mem.res_id = ?
                ORDER BY mem.res_role_id ASC';
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
            return $result;
        }
    }
}