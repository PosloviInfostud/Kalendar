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
        foreach($result as $user) {
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
        $sql = "SELECT id FROM res_items";
        $query = $this->db->query($sql);
        $items_arr = $query->result_array();
        $items = [];
        $free_arr = [];

        foreach($items_arr as $item) {
                $items[] = $item['id'];
        }
        $sql = "SELECT res_item_id as id FROM reservations GROUP BY res_item_id";
        $query = $this->db->query($sql);
        $reserved_arr = $query->result_array(); 

        foreach($reserved_arr as $reserv) {
                $reserved[] = $reserv['id'];
        }

        $non_reserved = array_diff($items, $reserved);

        foreach($non_reserved as $item) {
            $sql = "SELECT id, name FROM res_items WHERE id = ?";
            $query = $this->db->query($sql, [$item]);
            if ($query->num_rows()) {
                $result = $query->row_array();
            }
                $free_arr[] = $result;
        }

        $sql = "SELECT res_items.id, name FROM res_items 
                INNER JOIN reservations ON res_items.id = reservations.res_item_id 
                WHERE (? < reservations.start_time OR ? > reservations.end_time) 
                AND res_items.capacity > ? 
                ";
        $query = $this->db->query($sql, [$data['end_time'], $data['start_time'], $data['attendants']]);

        if ($query->num_rows()) {
            $result_arr = $query->result_array();
        }
        foreach ($result_arr as $item) {
            $free_arr[] = $item;
        }

        foreach($free_arr as $item) {
            foreach($item as $key => $value) {
                $free[] = $value;
            }
    }   
        var_dump($free); die;
        return $free;
    }
}