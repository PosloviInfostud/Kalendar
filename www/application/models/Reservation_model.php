<?php
class Reservation_model extends CI_Model
{
    public function invite_members($res_id)
    {
        $result = [];
        $sql = 'SELECT users.name, users.email, reservations.start_time, reservations.end_time, reservations.title, reservations.description
         FROM res_members 
         INNER JOIN users ON users.id = res_members.user_id 
         INNER JOIN reservations ON reservations.id = res_members.res_id 
         INNER JOIN res_items ON reservations.res_item_id = res_items.id
         WHERE res_members.res_role_id = 2 AND res_members.res_id = ?';
        $query = $this->db->query($sql, [$res_id]);
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        print_r($result);
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
                WHERE (room_reservations.start_time <= ? AND room_reservations.end_time > ?) OR (room_reservations.start_time < ? AND room_reservations.start_time >= ?) 
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
        // echo $reserved; die;
        $sql = "SELECT id, name FROM rooms 
                WHERE id NOT IN ('".$reserved."') 
                AND capacity > ?";
        $query = $this->db->query($sql,[$data['attendants']]);
        if($query->num_rows()) {
            $free = $query->result_array();
        } else {
            $free = [];
        }
        return $free; die;
    }

    public function show_users_for_invitation()
    {
        $cookie = $this->input->cookie('usr-vezba', true);
        $this->load->model('User_model', 'user');
        $admin = $this->user->get_user_by_token($cookie)['id'];

        $sql = "SELECT id, name FROM users WHERE id != ?";
        $query = $this->db->query($sql, [$admin]);

        if ($query->num_rows()) {
            $result = $query->result_array();
        }

        return $result;

    }

    public function submit_reservation_form($data)
    {
        $cookie = $this->input->cookie('usr-vezba', true);
        $this->load->model('User_model', 'user');
        $user_id = $this->user->get_user_by_token($cookie)['id'];

        $sql = "INSERT INTO room_reservations  
                (room_id, user_id, start_time, end_time, title, description) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $query = $this->db->query($sql, [$data['room'], $user_id, $data['start_time'], $data['end_time'], $data['title'], $data['description']]);

        $res_id = $this->db->insert_id();

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
        $data['members'][] = $user_id;
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

            $this->session->set_flashdata('flash_message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Success! Your reservation has been created!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            url_redirect('/dashboard');
            }
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
        $sql = "SELECT id FROM equipment 
                WHERE equipment_type_id = ?";
        $query = $this->db->query($sql, [$data['type']]);

        if ($query->num_rows()) {
            $result = $query->result_array();
        } else {
            $result = [];
        }

        $all = [];
        $reserved = [];
        $free = [];

        foreach($result as $row) {
            $all[] = $row['id'];
        }

        $sql = "SELECT equipment_id as id FROM equipment_reservations 
                INNER JOIN equipment ON equipment.id = equipment_reservations.equipment_id 
                WHERE equipment.equipment_type_id = ? 
                GROUP BY equipment_id";
        $query = $this->db->query($sql, [$data['type']]);

        if ($query->num_rows()) {
            $reserved_arr = $query->result_array();
        } else {
            $reserved_arr = [];
        }

        foreach($reserved_arr as $row) {
            $reserved[] = $row['id'];
        }

        $non_reserved = array_diff($all, $reserved);

        foreach($non_reserved as $item) {
            $sql = "SELECT id, name, barcode, description 
                    FROM equipment WHERE id = ?";
            $query = $this->db->query($sql, [$item]);
            if ($query->num_rows()) {
                $result = $query->row_array();
            }
            $free[] = $result;
        }
        $sql = "SELECT equipment.id, name, barcode, equipment.description 
                FROM equipment 
                INNER JOIN equipment_reservations ON equipment.id = equipment_reservations.equipment_id 
                WHERE (? < equipment_reservations.start_time OR ? > equipment_reservations.start_time)
                AND equipment.equipment_type_id = ? 
                GROUP BY equipment_id";
        $query = $this->db->query($sql, [$data['end_time'], $data['start_time'], $data['type']]);

        if ($query->num_rows()) {
            $result = $query->result_array();
        } else {
            $result = [];
        }
        foreach($result as $row) {
            $free[] = $row;
        }

        return $free;
    }

    public function submit_reservation_equip_form($data)
    {
        $cookie = $this->input->cookie('usr-vezba', true);
        $this->load->model('User_model', 'user');
        $user_id = $this->user->get_user_by_token($cookie)['id'];

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

        url_redirect('/dashboard');
    }
}