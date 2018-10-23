<?php
class Reminder_model extends CI_Model
{
    public function get_upcoming_meetings()
    {
        // Get meetings that start in the next 15 minutes
        $result = [];
        $sql = "SELECT res.id as reservation_id, 
                res.room_id, 
                room.name AS room_name, 
                res.title, 
                res.description, 
                res.start_time, 
                res.end_time 
                FROM room_reservations as res
                INNER JOIN rooms as room ON room.id = res.room_id
                WHERE NOW() >= DATE_SUB(res.start_time, INTERVAL 59 MINUTE)
                AND res.start_time > NOW()
                AND res.reminder_sent = 0
                AND res.deleted = 0";
        $query = $this->db->query($sql, []);
        if($query->num_rows()) {
            $result = $this->beautify->upcoming_meetings_data($query->result_array());
        }
        return $result;
    }

    public function get_meeting_members($id)
    {
        $result = [];
        $sql = "SELECT u.name, u.email 
                FROM res_members AS mem
                INNER JOIN users AS u ON u.id = mem.user_id
                WHERE mem.res_id = ?
                AND mem.deleted = 0";
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
            $emails = [];
            // Extract emails for a given meeting
            foreach($meeting['members'] as $member) {
                $emails[] = $member['email'];
            }
            $meeting_details = [
                'room' => $meeting['room_name'],
                'title' => $meeting['title'],
                'start_time' => $meeting['start_time'],
                'duration' => $meeting['duration'],
                'description' => $meeting['description']
            ];

            // Prepare mail
            $email_details = $this->prepare_mails($meeting_details);

            // Add mails to queue
            $this->mail->add_mail_to_queue($emails, $email_details);
        }
    }

    public function prepare_mails($data)
    {
        $email_details = [];

        // Set your email information
        $email_details['from'] = 'visnjamarica@gmail.com';
        $email_details['subject'] = '[Reminder] Your meeting in '.$data['room'].' is about to start!';
        $email_details['message'] = '<html>
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

        return $email_details;
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