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
        // Prepare mail
        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'New meeting';
        $email_details['message'] = $this->load->view('reservation_invitation_mail', $user, TRUE);

        // Add email to queue
        $this->mail->add_mail_to_queue(array($user['email']), $email_details);
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
        
        $data = $this->check_members_reg($data);

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
        $this->insert_unregistered_members($data);
        $this->invite_members($data['res_id']);
        $this->invite_unregistered_members($data['res_id']);
    }

    public function check_members_reg($data)
    {
        $data['unregistered'] = [];
        $data['registered'] = [];
        foreach($data['members'] as $member) {
            $sql = "SELECT id FROM users WHERE email = ?";
            $query = $this->db->query($sql, [$member]);

            if($query->num_rows() == 0) {
                $data['unregistered'][] = $member;
            } else {
                $result = $query->row_array();
                $data['registered'][] = $result['id'];
            }
        }
        return $data;
    }

    public function insert_unregistered_members($data)
    {
        $this->load->library('encryption');
        $res_id = $data['res_id'];
        $user_id = $data['admin'];
        foreach($data['unregistered'] as $unregistered) {

            $invite_token = bin2hex($this->encryption->create_key(16));
            $expire = date('Y-m-d h:i:s', strtotime('+2 days'));

            $sql = "INSERT INTO pending_users 
                    (email, res_id, invited_by, invite_token, invite_token_exp) 
                    VALUES (?, ?, ?, ?, ?)";
            $query = $this->db->query($sql, [$unregistered, $res_id, $user_id, $invite_token, $expire]);

            $data_log = [
                'user_id' => $user_id,
                'table' => 'pending_users',
                'type' => 'insert',
                'value' => [
                    'email' => $unregistered,
                    'res_id' => $res_id,
                    'invite_token' => $invite_token,
                    'invite_token_exp' => $expire
                ]
            ];
            $this->logs->insert_log($data_log);
        }
    }

    public function invite_unregistered_members($res_id)
    {
        $result = [];
        $sql = 'SELECT 
                users.name as admin_name, 
                users.email as admin_mail, 
                room_reservations.start_time as start, 
                room_reservations.end_time as end, 
                room_reservations.title as title, 
                rooms.name as room,
                pending_users.email as email,
                pending_users.invite_token as token,
                pending_users.invite_token_exp as exp
                FROM pending_users 
                INNER JOIN users ON users.id = pending_users.invited_by 
                INNER JOIN room_reservations ON room_reservations.id = pending_users.res_id 
                INNER JOIN rooms ON room_reservations.room_id = rooms.id
                WHERE pending_users.res_id = ?';
        $query = $this->db->query($sql, [$res_id]);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        foreach ($result as $user) {
            $this->send_invitation_mail($user);
        }
    }

    public function send_invitation_mail($user)
    {
        // Prepare email
        $email_details = [];

        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'New Meeting/Invitation for Registration';
        $email_details['message'] = $this->load->view('registration_invitation_mail', $user, TRUE);

        // Add email to queue
        $this->mail->add_mail_to_queue(array($user['email']), $email_details);
    }

    public function insert_reservation_members($data)
    {   
        $res_id = $data['res_id'];
        $user_id = $data['admin'];
        foreach ($data['registered'] as $member) {
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
        $sql = 'SELECT mem.user_id, mem.res_role_id, r.name AS role, u.name, u.email FROM res_members AS mem
                INNER JOIN users AS u ON u.id = mem.user_id 
                INNER JOIN res_roles AS r ON r.id = mem.res_role_id
                WHERE mem.res_id = ? AND mem.deleted = 0 
                ORDER BY mem.res_role_id ASC';
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
            return $result;
        }
    }

    public function new_registered_member($user_id, $token)
    {
        $result = [];
        $sql = "SELECT res_id FROM pending_users WHERE invite_token = ? ";
        $query = $this->db->query($sql, [$token]);
        if ($query->num_rows()){
            $result = $query->row_array();
        }
        $res_id = $result['res_id'];
        
        $sql = "INSERT INTO res_members (res_id, user_id) 
                VALUES (?, ?)";
        $query = $this->db->query($sql, [$res_id, $user_id]);

        $data_log = [
            'user_id' => $user_id,
            'table' => 'res_members',
            'type' => 'insert',
            'value' => [
                'res_id' => $res_id,
                'member' => $user_id
            ]
        ];
        $this->logs->insert_log($data_log);

        $sql = "UPDATE pending_users 
                SET registered = 1, invite_token = '', modified_at = NOW() 
                WHERE invite_token = ?";
        $query = $this->db->query($sql, [$token]);

        $data_log = [
            'user_id' => $user_id,
            'table' => 'pending_users',
            'type' => 'update',
            'value' => [
                'registered' => "1",
                'invite_token' => ""
            ]
        ];
        $this->logs->insert_log($data_log);
    }

    public function update_user_role($data)
    {
        if($data['creator'] == $data['user_id']) {
            $message['error'] = "You cannot change the role for the creator of the meeting!";

        } else {
            $sql = "UPDATE res_members SET res_role_id = ? WHERE res_id = ? AND user_id = ?";
            $query = $this->db->query($sql, [$data['role_id'], $data['res_id'], $data['user_id']]);
    
            $user_id = $this->user_data['user']['id'];
            $data_log = [
                'user_id' => $user_id,
                'table' => 'res_members',
                'type' => 'update',
                'value' => [
                    'res_id' => $data['res_id'],
                    'user_id' => $data['user_id'],
                    'res_role_id' => $data['role_id']
                ]
            ];
            $this->load->model('Logs_model', 'logs');
            $this->logs->insert_log($data_log);

            $message['success'] = "success";
        }
        echo json_encode($message);


    }

    public function delete_res_member($data)
    {
        if($data['creator'] == $data['member']) {
            $message['error'] = "You cannot delete the creator of the meeting!";

        } else {
            $sql = "UPDATE res_members 
                    SET deleted = 1 
                    WHERE res_id = ? AND user_id = ?";
            $query = $this->db->query($sql, [$data['res'], $data['member']]);

            $user_id = $this->user_data['user']['id'];
            $data_log = [
                'user_id' => $user_id,
                'table' => 'res_members',
                'type' => 'delete',
                'value' => [
                    'res_id' => $data['res'],
                    'user_id' => $data['member'],
                ]
            ];
            $this->load->model('Logs_model', 'logs');
            $this->logs->insert_log($data_log);
            
            $message['success'] = "success";
        }
        echo json_encode($message);
    }

    function get_users_not_res_members($id)
    {
        $members = [];
        $result = [];
        $sql = "SELECT user_id FROM res_members WHERE res_id = ?";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
        }
        foreach ($result as $row) {
            $members[] = $row['user_id'];
        }
        $members = implode(",", $members);

        $sql = "SELECT id, name, email FROM users WHERE id NOT IN (".$members.")";
        $query = $this->db->query($sql);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function check_if_member_already_invited($data)
    {
        foreach($data['registered'] as $member) {
            $sql = "SELECT COUNT(*) AS reserved FROM room_reservations 
                    WHERE user_id = ? AND room_id = ?";
            $query = $this->db->query($sql, [$member, $data['res_id']]);

            if($query->num_rows()) {
                $result = $query->row_array();
            }

            if ($result['reserved'] == 1) {
                $this->removeElement($data['registered'], $member);
            }
        }

        return $data;
    }
    
    public function removeElement($array,$value) 
    {
        if (($key = array_search($value, $array)) !== false) {
        unset($array[$key]);
        }
        return $array;
    }

    public function update_room_reservation($data)
    {
        $sql = "UPDATE room_reservations 
                SET room_id = ?, start_time = ?, end_time = ?, modified_at = NOW(), title = ?, description = ? 
                WHERE id = ?";
        $query = $this->db->query($sql, [$data['room'], $data['start_time'], $data['end_time'], $data['title'], $data['description'], $data['id']]);

        $user_id = $this->user_data['user']['id'];
        $data_log = [
            'user_id' => $user_id,
            'table' => 'room_reservations',
            'type' => 'update',
            'value' => [
                'room_id' => $data['room'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'title' => $data['title'],
                'description' => $data['description']
            ]
        ];
        $this->logs->insert_log($data_log);
    }

    public function check_if_room_is_free_for_update($data)
    {
        $sql = "SELECT COUNT(*) AS reserved FROM room_reservations 
                WHERE ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?)) 
                AND room_id = ? AND id != ?"; 
        $query = $this->db->query($sql,[$data['start_time'], $data['start_time'], $data['end_time'], $data['start_time'], $data['room'], $data['id']]);

        if($query->num_rows()) {
            $result = $query->row_array();
        }
        if ($result['reserved'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_room_reservation($id)
    {
       $sql = "UPDATE room_reservations 
                SET deleted = 1, modified_at = NOW()
                WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        $user_id = $this->user_data['user']['id'];
        $data_log = [
            'user_id' => $user_id,
            'table' => 'room_reservations',
            'type' => 'delete',
            'value' => [
                'id' => $id
            ]
        ];
        $this->logs->insert_log($data_log);
    }

    public function check_if_equipment_is_free_for_update($data)
    {  
        $sql = "SELECT COUNT(*) AS reserved FROM equipment_reservations 
                WHERE 
                ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?))
                AND equipment_id = ? AND id != ?";
        $query = $this->db->query($sql, [$data['start_time'], $data['start_time'], $data['end_time'], $data['start_time'], $data['equip_id'], $data['res_id']]);
        if($query->num_rows()) {
            $result = $query->row_array();
        }
        if ($result['reserved'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_equip($data)
    {
        $sql = "UPDATE equipment_reservations SET start_time = ?, end_time = ?, description = ?, modified_at = NOW() 
                WHERE id = ?";
        $query = $this->db->query($sql, [$data['start_time'], $data['end_time'], $data['description'], $data['res_id']]);

        $user_id = $this->user_data['user']['id'];
        $data_log = [
            'user_id' => $user_id,
            'table' => 'equipment_reservations',
            'type' => 'update',
            'value' => [
                'id' => $data['res_id'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'description' => $data['description']
            ]
        ];
        $this->logs->insert_log($data_log);
    }

    public function delete_equipment_reservation($id)
    {
       $sql = "UPDATE equipment_reservations 
                SET deleted = 1, modified_at = NOW()
                WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        $user_id = $this->user_data['user']['id'];
        $data_log = [
            'user_id' => $user_id,
            'table' => 'equipment_reservations',
            'type' => 'delete',
            'value' => [
                'id' => $id
            ]
        ];
        $this->logs->insert_log($data_log);
    }

}