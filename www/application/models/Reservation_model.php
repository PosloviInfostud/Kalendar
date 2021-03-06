<?php
class Reservation_model extends CI_Model
{
    public function invite_members($res_id)
    {
        $result = [];
        $sql = "SELECT u.name, 
                u.email, 
                res.start_time, 
                res.end_time, 
                res.title, 
                rooms.name AS room,
                res.description
                FROM res_members AS mem 
                INNER JOIN users AS u ON u.id = mem.user_id 
                INNER JOIN room_reservations AS res ON res.id = mem.res_id 
                INNER JOIN rooms ON res.room_id = rooms.id
                WHERE mem.res_role_id = 2 
                AND mem.res_id = ? 
                AND res.parent = '0'
                AND res.deleted = '0' 
                AND u.not_create = '1'";
        $query = $this->db->query($sql, [$res_id]);
        if ($query->num_rows()) {
            
            $result = $query->result_array();
        }
        foreach ($result as $user) {
            
            $user['day'] = date('l (d/m/y)', strtotime($user['start_time']));
            $user['time'] = date('H:i', strtotime($user['start_time']))." - ".date('H:i', strtotime($user['end_time']));
            $user['starttime'] = date('D @ H:i (d/m/y)', strtotime($user['start_time']));

            $this->send_members_notification($user);
        }
    }

    public function invite_new_members($res_id, $registered)
    {
        $result = [];

        foreach ($registered as $user) {
            $sql = "SELECT u.name, 
                    u.email, 
                    res.start_time, 
                    res.end_time, 
                    res.title, 
                    rooms.name AS room,
                    res.description
                    FROM res_members AS mem 
                    INNER JOIN users AS u ON u.id = mem.user_id 
                    INNER JOIN room_reservations AS res ON res.id = mem.res_id 
                    INNER JOIN rooms ON res.room_id = rooms.id
                    WHERE u.id = ?
                    AND mem.res_id = ? 
                    AND res.deleted = '0' 
                    AND u.not_create = '1'";
            $query = $this->db->query($sql, [$user, $res_id]);
            if ($query->num_rows()) {
            $result = $query->row_array();

            $result['day'] = date('l (d/m/y)', strtotime($result['start_time']));
            $result['time'] = date('H:i', strtotime($result['start_time']))." - ".date('H:i', strtotime($result['end_time']));
            $result['starttime'] = date('D @ H:i (d/m/y)', strtotime($result['start_time']));
            }

            $this->send_members_notification($result);
        }
    }

    public function send_members_notification($user)
    {
        // Prepare mail
        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'Novi sastanak';
        $email_details['message'] = $this->load->view('mails/reservation_invitation_mail', $user, TRUE);

        // Add email to queue
        $this->mail->add_mail_to_queue(array($user['email']), $email_details);
    }

    public function get_reservation_frequencies()
    {
        $result = [];
        $sql = "SELECT * FROM res_frequency";
        $query = $this->db->query($sql, []);

        if($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function check_free_rooms($data)
    {
        $reserved_arr = [];
        $free = [];
        $sql = "SELECT rooms.id 
                FROM rooms 
                INNER JOIN room_reservations ON rooms.id = room_reservations.room_id 
                WHERE ((room_reservations.start_time < ? AND room_reservations.end_time > ?) 
                OR (room_reservations.start_time < ? AND room_reservations.start_time >= ?)) 
                AND (room_reservations.recurring = 0 OR room_reservations.parent != 0) 
                AND room_reservations.deleted = '0'
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
            $sql = "SELECT id, name 
            FROM rooms 
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
        $result = [];
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
        $sql = "SELECT COUNT(*) AS reserved 
                FROM room_reservations 
                WHERE ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?)) 
                AND (recurring = '0' OR parent != '0') 
                AND room_id = ?
                AND deleted = 0"; 
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
        $sql = "SELECT COUNT(*) AS reserved 
                FROM equipment_reservations 
                WHERE ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?))
                AND equipment_id = ?
                AND deleted = 0";
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

    public function check_if_room_is_free_for_child($data)
    {
        $result = [];

        $sql = "SELECT room.user_id,
                u.name,
                room.start_time,
                room.end_time
                FROM room_reservations AS room
                INNER JOIN users AS u ON room.user_id = u.id
                WHERE ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?)) 
                AND (recurring = '0' OR parent != '0') 
                AND room_id = ?
                AND deleted = 0"; 
        $query = $this->db->query($sql,[$data['start'], $data['start'], $data['end'], $data['start'], $data['room']]);

        if($query->num_rows()) {
            $result = $query->row_array();
        }
        return $result;
    }

    public function submit_reservation_form($data)
    {
        $period = [];
        $parent_id = [];
        $conflict = [];
        $conflicts = false;

        $user_id = $this->user_data['user']['id'];
        $data = $this->check_members_reg($data);

        // Build the insert SQL
        $sql = "INSERT INTO room_reservations
                (room_id, user_id, start_time, end_time, title, description, recurring, frequency_id, parent) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $freq = $data['frequency'];

        // Check if it's a one-time or recurring 
        if($freq == '1') {
            // It's a one-time thing
            $query = $this->db->query($sql, [$data['room'], $user_id, $data['start_time'], $data['end_time'], $data['title'], $data['description'], FALSE, $freq, 0]);
            $parent_id = $this->db->insert_id();
        } else {
            // Recurring reservations
            // daily
            if($freq == '2') {
                $period = $this->datetime->get_reccuring_dates($data, '1', 'D', '1');
            // weekly
            } elseif($freq == '3') {
                $period = $this->datetime->get_reccuring_dates($data, '1', 'W', '1');
            // bi-weekly
            } elseif($freq == '4') {
                $period = $this->datetime->get_reccuring_dates($data, '2', 'W', '1');
            // monthly
            } elseif($freq == '5') {
                $period = $this->datetime->get_reccuring_dates($data, '1', 'M', '3');
            }

            // Create parent reservation
            $query = $this->db->query($sql, [$data['room'], $user_id, $period['first_start_date'], $period['last_end_date'], $data['title'], $data['description'], TRUE, $freq, 0]);
            $parent_id = $this->db->insert_id();
            
            // Create child reservations
            $conflicts_msg = "Sastanak je kreiran ali postoje konflikti. <br />";

            foreach($period['reservations'] as $res) {
                // Include room id needed for conflict check
                $res['room'] = $data['room'];
                // Child dates that are in conflict with existing reservations
                $conflict = $this->check_if_room_is_free_for_child($res);
                // if conflict isn't empty add it to the conflicts message and set conflict to true
                if(!empty($conflict)) {
                    $conflicts = true;
                    $conflicts_msg .= $conflict['name'] . " (od: " . $conflict['start_time'] . " do: " . $conflict['end_time'] . ")<br>";
                }
                // Insert into db
                $query = $this->db->query($sql, [$data['room'], $user_id, $res['start'], $res['end'], $data['title'], $data['description'], TRUE, $freq, $parent_id]);
                $data['res_id'] = $this->db->insert_id();
                $data['admin'] = $user_id;
                $this->insert_reservation_members($data);
                $this->insert_creator_into_res_members($data['res_id'], $user_id);
            }
        }

        $data['res_id'] = $parent_id;
        $data['admin'] = $user_id;

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

        // Notification (with and without conflicts)
        if($conflicts) {
            $msg = $this->alerts->render('orange', 'Rezervisano sa konfliktima', $conflicts_msg);
            // Notify creator about the conflicts
            $this->send_mail_about_conflicts($data['title'], $conflicts_msg);
        } else {
            $msg = $this->alerts->render('teal', 'Rezervisano!', 'Rezervacija uspešno kreirana.');
        }
        $this->session->set_flashdata('flash_message', $msg);

        $this->insert_reservation_members($data);
        $this->insert_creator_into_res_members($data['res_id'], $user_id);
        $this->insert_unregistered_members($data);
        $this->invite_members($data['res_id']);
        $this->invite_unregistered_members($data['res_id']);
    }

    public function send_mail_about_conflicts($title, $conflicts_msg)
    {
        // Prepare email
        $email = $this->user_data['user']['email'];
        $email_details = [];

        $email_details['from'] = "visnjamarica@gmail.com";
        $email_details['subject'] = "Konflikti za rezervaciju: $title";
        $email_details['message'] = $conflicts_msg;

        // Add email to queue
        $this->mail->add_mail_to_queue(array($email), $email_details);
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
        $sql = "SELECT u.name as admin_name, 
                u.email as admin_mail, 
                res.start_time as start, 
                res.end_time as end, 
                res.title as title, 
                rooms.name as room,
                pu.email as email,
                pu.invite_token as token,
                pu.invite_token_exp as exp
                FROM pending_users AS pu
                INNER JOIN users AS u ON u.id = pu.invited_by 
                INNER JOIN room_reservations AS res ON res.id = pu.res_id 
                INNER JOIN rooms ON res.room_id = rooms.id
                WHERE pu.res_id = ?";
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
        $email_details['subject'] = 'Novi sastanak/Poziv';
        $email_details['message'] = $this->load->view('registration_invitation_mail', $user, TRUE);

        // Add email to queue
        $this->mail->add_mail_to_queue(array($user['email']), $email_details);
    }

    public function insert_reservation_members($data)
    {   
        $res_id = $data['res_id'];
        $user_id = $data['admin'];
        foreach ($data['registered'] as $member) {
            $sql = "SELECT not_update, not_remind FROM users WHERE id = ?";
            $query = $this->db->query($sql, [$member]);
            if ($query->num_rows()) {
                $result = $query->row_array();
            }
            $notify['update'] = $result['not_update'];
            $notify['remind'] = $result['not_remind'];

            $sql = "INSERT INTO res_members 
                    (res_id, user_id, not_update, not_remind) 
                    VALUES (?, ?, ?, ?)";
            $query = $this->db->query($sql, [$res_id, $member, $notify['update'], $notify['remind']]);
            $data_log = [
                'user_id' => $user_id,
                'table' => 'res_members',
                'type' => 'insert',
                'value' => [
                    'res_id' => $res_id,
                    'member' => $member,
                    'not_update' => $notify['update'],
                    'not_remind' => $notify['remind']
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

    public function get_all_equipment_types()
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
        $sql = "SELECT equipment.id AS id 
                FROM equipment 
                INNER JOIN equipment_reservations ON equipment.id = equipment_reservations.equipment_id  
                WHERE ((equipment_reservations.start_time < ? AND equipment_reservations.end_time > ?) 
                OR (equipment_reservations.start_time < ? AND equipment_reservations.start_time >= ?)) 
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
        $sql = "SELECT id, barcode, name, description 
                FROM  equipment 
                WHERE equipment_type_id = ?";
        $query = $this->db->query($sql, [$data['type']]);

        if($query->num_rows()) {
            $free = $query->result_array();
        }
    } 
    else {
        $sql = "SELECT id, barcode, name, description 
                FROM  equipment 
                WHERE id NOT IN (".$reserved.") 
                AND equipment_type_id = ?";
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

        // Notification
        $msg = $this->alerts->render('teal', 'Rezervisano!', 'Uspešno izvršena rezervacija.');
        $this->session->set_flashdata('flash_message', $msg);
    }

    public function room_reservations_by_user($id)
    {
        $result = [];
        $sql = "SELECT mem.res_id,
                mem.user_id, 
                mem.res_role_id, 
                res.room_id, 
                room.name as room_name, 
                res.user_id as creator_id, 
                u.name as created_by, 
                res.title,
                res.description, 
                res.start_time, 
                res.end_time,
                res.recurring,
                res.frequency_id,
                freq.name AS frequency_name
                FROM res_members as mem
                INNER JOIN room_reservations as res ON res.id = mem.res_id
                INNER JOIN users as u ON res.user_id = u.id
                INNER JOIN rooms as room ON room.id = res.room_id
                INNER JOIN res_frequency as freq ON res.frequency_id = freq.id
                WHERE mem.user_id = ? 
                AND res.end_time >= NOW()
                AND res.deleted = '0'
                AND (res.recurring = '0' OR res.parent != '0')
                ORDER BY res.start_time ASC";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_meetings_view_data($query->result_array());
            return $result;
        }
    }

    public function single_room_reservation($id)
    {
        $result = [];
        $sql = "SELECT res.id, 
                res.user_id AS creator_id, 
                u.name AS creator_name, 
                res.start_time, 
                res.end_time, 
                res.created_at, 
                res.room_id, 
                room.name, 
                res.title, 
                res.description,
                res.recurring,
                res.parent,
                res.frequency_id,
                freq.name AS frequency_name
                FROM room_reservations AS res
                INNER JOIN users as u ON res.user_id = u.id
                INNER JOIN rooms as room ON room.id = res.room_id
                INNER JOIN res_frequency as freq ON res.frequency_id = freq.id
                WHERE res.id = ?";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_meetings_view_data($query->result_array());
            return $result;
        }
    }

    public function equipment_reservations_by_user($id)
    {
        $result = [];
        $sql = "SELECT res.id, 
                res.equipment_id, 
                res.start_time, 
                res.end_time, 
                res.description, 
                e.name as item_name, 
                type.name as item_type 
                FROM equipment_reservations as res
                INNER JOIN equipment as e ON e.id = res.equipment_id
                INNER JOIN equipment_types as type ON type.id = e.equipment_type_id
                WHERE res.user_id IN ?
                AND res.end_time > NOW()
                AND res.deleted = '0'";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_equipment_view_data($query->result_array());
            return $result;
        }
    }

    public function single_equipment_reservation($id)
    {
        $result = [];
        $sql = "SELECT res.id, 
                res.equipment_id, 
                res.start_time, 
                res.end_time, 
                res.description, 
                res.user_id, 
                e.name AS item_name, 
                type.name AS item_type 
                FROM equipment_reservations AS res
                INNER JOIN equipment AS e ON e.id = res.equipment_id
                INNER JOIN equipment_types AS type ON type.id = e.equipment_type_id
                WHERE res.id = ?
                AND res.deleted = '0'";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $this->beautify->user_equipment_view_data($query->result_array());
            return $result;
        }
    }

    public function get_reservation_members($id)
    {
        $result = [];
        $sql = "SELECT mem.user_id, 
                mem.res_role_id, 
                r.name AS role, 
                u.name, 
                u.email 
                FROM res_members AS mem
                INNER JOIN users AS u ON u.id = mem.user_id 
                INNER JOIN res_roles AS r ON r.id = mem.res_role_id
                WHERE mem.res_id = ? 
                AND mem.deleted = 0 
                ORDER BY mem.id ASC";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
            return $result;
        }
    }

    public function new_registered_member($user_id, $token)
    {
        $result = [];
        $recurring = "";
        $sql = "SELECT res_id FROM pending_users WHERE invite_token = ?";
        $query = $this->db->query($sql, [$token]);
        if ($query->num_rows()){
            $result = $query->row_array();
        }
        $res_id = $result['res_id'];

        $sql = "SELECT recurring FROM room_reservations WHERE id = ?";
        $query = $this->db->query($sql, [$res_id]);
        if ($query->num_rows()){
            $result = $query->row_array();
        }
        $recurring = $result['recurring'];
        
        if ($recurring == '1') {
            $children = $this->get_child_reservations($res_id);
            foreach ($children as $child) {

                $sql = "INSERT INTO res_members (res_id, user_id) 
                VALUES (?, ?)";
                $query = $this->db->query($sql, [$child['id'], $user_id]);

                $data_log = [
                    'user_id' => $user_id,
                    'table' => 'res_members',
                    'type' => 'insert',
                    'value' => [
                        'res_id' => $child['id'],
                        'member' => $user_id
                    ]
                ];
                $this->logs->insert_log($data_log);
            }
        }
        elseif ($recurring == '0') {
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
}


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
            $message['error'] = "Kreatoru sastanka ne može da bude promenjena uloga!";

        } else {
            $sql = "UPDATE res_members SET res_role_id = ?, modified_at = NOW()  WHERE res_id = ? AND user_id = ?";
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
            $this->logs->insert_log($data_log);

            $message['success'] = "success";
        }
        echo json_encode($message);

    }

    public function delete_res_member($data)
    {
        if($data['creator'] == $data['member']) {
            $message['error'] = "Kreator sastanka ne može da bude obrisan!";

        } else {
            $sql = "UPDATE res_members 
                    SET deleted = 1, modified_at = NOW() 
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
            $this->logs->insert_log($data_log);
            $this->load->model('User_model','user');
            $member = $this->user->get_single_user($data['member']);
            $reservation = $this->single_room_reservation($data['res'])[0];
            $notify = $this->get_if_member_is_notified($data['res'], $data['member']);

            if($notify['update'] == 1) {
                $this->send_delete_member_mail($member, $reservation);
            }
            
            $message['success'] = "success";
        }
        echo json_encode($message);
    }

    function get_users_not_res_members($id)
    {
        $members = [];
        $result = [];
        $sql = "SELECT user_id FROM res_members WHERE res_id = ? AND deleted = 0";
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
            $sql = "SELECT COUNT(*) AS reserved 
                    FROM room_reservations 
                    WHERE user_id = ? 
                    AND room_id = ?
                    AND deleted = 0";
            $query = $this->db->query($sql, [$member, $data['res_id']]);

            if($query->num_rows()) {
                $result = $query->row_array();
            }

            if ($result['reserved'] == 1) {
                $this->beautify->removeElement($data['registered'], $member);
            }
        }

        return $data;
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
        //Send e-mail notification if checkbox is checked
        if($data['send_email_update'] == 'true') {
            $members = $this->get_all_reservation_mails($data['id']);
            $reservation = $this->single_room_reservation($data['id'])[0];
            $this->send_updated_meeting_mail($members, $reservation);        
        }

    }

    public function check_if_room_is_free_for_update($data)
    {
        $sql = "SELECT COUNT(*) AS reserved 
                FROM room_reservations 
                WHERE ((start_time < ? AND end_time > ?) 
                OR (start_time < ? AND start_time >= ?)) 
                AND (recurring = '0' OR parent != '0') 
                AND room_id = ? 
                AND id != ?
                AND deleted = 0"; 
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

    public function delete_room_reservation($id, $child = FALSE)
    {
       // Delete from the reservations table
       $sql = "UPDATE room_reservations 
                SET deleted = 1, modified_at = NOW()
                WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        // Log action
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

        // Delete from the members table
        $sql = "UPDATE res_members 
                SET deleted = 1, modified_at = NOW()
                WHERE res_id = ?";
        $query = $this->db->query($sql, [$id]);

        // Log action
        $data_log = [
            'user_id' => $user_id,
            'table' => 'res_members',
            'type' => 'delete',
            'value' => [
                'id' => $id
            ]
        ];
        $this->logs->insert_log($data_log);

        //Send e-mail notification
        if($child == FALSE) {
            $members = $this->get_all_reservation_mails($id);
            $reservation = $this->single_room_reservation($id)[0];
            $this->send_cancelled_meeting_mail($members, $reservation);
        }
    }

    public function check_if_equipment_is_free_for_update($data)
    {  
        $sql = "SELECT COUNT(*) AS reserved 
                FROM equipment_reservations 
                WHERE ((start_time < ? AND end_time > ?) OR (start_time < ? AND start_time >= ?))
                AND equipment_id = ? 
                AND id != ?
                AND deleted = 0";
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

    public function send_cancelled_meeting_mail($members, $reservation)
    {
        // Prepare mail
        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'Sastanak otkazan';
        $email_details['message'] = $this->load->view('mails/cancelled_meeting_mail', ['members' => $members, 'reservation'=>$reservation], TRUE);

        // Add email to queue
        $this->mail->add_mail_to_queue($members, $email_details);
    }

    public function send_updated_meeting_mail($members, $reservation)
    {
        // Prepare mail
        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'Ažurirani podaci o sastanku';
        $email_details['message'] = $this->load->view('mails/updated_meeting_mail', ['members' => $members, 'reservation'=>$reservation], TRUE);

        // Add email to queue
        $this->mail->add_mail_to_queue($members, $email_details);
    }

    public function send_delete_member_mail($member, $reservation)
    {
        // Prepare mail
        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = 'Sastanak otkazan';
        $email_details['message'] = $this->load->view('mails/deleted_member_mail', ['member' => $member, 'reservation'=> $reservation], TRUE);
        // Add email to queue
        $this->mail->add_mail_to_queue(array($member['email']), $email_details);
    }

    public function get_all_reservation_mails($id)
    {
        $result = [];
        $pending = [];
        $members = [];
        $sql = "SELECT u.email FROM res_members AS mem
                INNER JOIN users AS u ON u.id = mem.user_id 
                WHERE mem.res_id = ? 
                AND mem.not_update = '1'";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
        }
        foreach ($result as $member) {
            $members[] = $member['email'];
        }

        $sql = "SELECT email FROM pending_users WHERE res_id = ? AND registered = 0";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $pending = $query->result_array();
        }
        foreach ($pending as $member) {
            $members[] = $member['email'];
        }

        return $members;
    }

    public function get_all_editors($id)
    {
        $editors = [];
        $result = [];
        $sql = "SELECT user_id FROM res_members WHERE res_role_id = 1 AND res_id = ?";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
        }
        foreach($result as $row) {
            $editors[] = $row['user_id'];
        }
        return $editors;
    }

    public function get_child_reservations($id)
    {
        $result = [];
        $sql = "SELECT res.id, 
                res.start_time,
                res.end_time
                FROM room_reservations AS res
                WHERE res.parent = ?
                AND res.deleted = '0'";
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
            return $result;
        }
    }
    public function get_if_member_is_notified($res_id, $user_id)
    {
        $result = [];
        $sql = "SELECT not_update, not_remind FROM res_members WHERE res_id = ? AND user_id = ?";
        $query = $this->db->query($sql, [$res_id, $user_id]);

        if($query->num_rows()) {
            $result = $query->row_array();
        }
        $notify['update'] = $result['not_update'];
        $notify['remind'] = $result['not_remind'];

        return $notify;
    }

    public function change_member_notifications($user_id, $res_id, $notify, $column)
    {
        $sql = "UPDATE res_members SET ".$column." = ?, modified_at = NOW() WHERE user_id = ? AND res_id = ?";
        $query = $this->db->query($sql, [$notify, $user_id, $res_id]);

        $data_log = [
            'user_id' => $user_id,
            'table' => 'res_members',
            'type' => 'update',
            'value' => [
                'res_id' => $res_id,
                $column => $notify
                ]
        ];
        $this->logs->insert_log($data_log);       
    }
}