<?php
class Reminder_model extends CI_Model
{
    public function get_upcoming_meetings()
    {
        // Get meetings that start in the next 15 minutes
        $result = [];
        $sql = 'SELECT res.id as reservation_id, 
                res.room_id, 
                room.name AS room_name, 
                res.title, 
                res.description, 
                res.start_time, 
                res.end_time 
                FROM room_reservations as res
                INNER JOIN rooms as room ON room.id = res.room_id
                WHERE NOW() >= DATE_SUB(res.start_time, INTERVAL 15 MINUTE)
                AND res.start_time > NOW()
                AND res.reminder_sent = 0';
        $query = $this->db->query($sql, []);
        if($query->num_rows()) {
            $result = $this->beautify->upcoming_meetings_data($query->result_array());
        }
        return $result;
    }

    public function get_meeting_members($id)
    {
        $result = [];
        $sql = 'SELECT u.name, u.email FROM res_members AS mem
                INNER JOIN users AS u ON u.id = mem.user_id
                WHERE mem.res_id = ?';
        $query = $this->db->query($sql, [$id]);

        if($query->num_rows()) {
            $result = $query->result_array();
            return $result;
        }
    }

    public function include_meeting_members($meetings)
    {
        $extended_events = [];
        foreach($meetings as $key => $meeting) {
            $extended_events[$key] = $meeting;
            $extended_events[$key]['members'] = $this->get_meeting_members($meeting['reservation_id']);
        }
        return $extended_events;
    }

    public function notify_members_of_upcoming_meeting($ext_meetings)
    {
        $emails = [];
        $data = [];

        foreach($ext_meetings as $meeting) {
            // Extract emails for a given meeting
            foreach($meeting['members'] as $member) {
                $emails[] = $member['email'];
            }
            $data = [
                'room' => $meeting['room_name'],
                'title' => $meeting['title'],
                'start_time' => $meeting['start_time'],
                'duration' => $meeting['duration'],
                'description' => $meeting['description']
            ];
            $this->send_notification_mail($emails, $data);
            
        }
    }

    public function send_notification_mail($emails, $data)
    {
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
            'name' => 'Kalendar | INFOSTUD'
        ];
        $to = $emails;
        $subject = '[Reminder] Your meeting in '.$data['room'].' is about to start!';
        //  $message = 'Type your gmail message here'; // use this line to send text email.
        // load view file called "welcome_message" in to a $message variable as a html string.
        $message = '<html>
                        <head>
                            <title>Your meeting in '.$data['room'].' is about to start!</title>
                        </head>
                        <body>
                            <h2>'.$data['title'].'</h2>
                            <p><strong>When:</strong> '.$data['start_time'].'</p>
                            <p><strong>Where:</strong> '.$data['room'].'</p>
                            <p><strong>Duration:</strong> '.$data['duration'].' mins</p>
                            <p><strong>About:</strong> '. $data['description'].'</p>
                        </body>
                    </html>';
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

    public function mark_meetings_as_sent($meetings)
    {
        // Extract ids
        $meeting_ids = [];
        foreach($meetings as $meeting) {
            $meeting_ids [] = $meeting['reservation_id'];
        }

        // Update db
        $sql = "UPDATE room_reservations SET reminder_sent = 1 WHERE id IN ?";
        $query = $this->db->query($sql, [$meeting_ids]);
    }
}