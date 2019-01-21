<?php
class Mail_model extends CI_Model
{
    public function add_mail_to_queue($emails, $details)
    {
        $data = [];

        foreach($emails as $email) {
            $data[] = [
                'send_from' => $details['from'],
                'send_to' => $email,
                'subject' => $details['subject'],
                'message' => $details['message']
            ];
        }

        $this->db->insert_batch('mail_queue', $data);
    }

    public function get_pending_mails($num = 50)
    {
        $result = [];

        $sql = "SELECT id, 
                send_from, 
                send_to, 
                subject, 
                message
                FROM mail_queue
                WHERE status = 'pending'
                ORDER BY created_at ASC
                LIMIT ?";
        $query = $this->db->query($sql, [$num]);
        
        if($query->num_rows()) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function send_pending_mails($pending_emails)
    {
        if(!empty($pending_emails)) {
            foreach($pending_emails as $email) {
                $this->send_mail($email);
            }
        }
    }
    
    public function send_mail($email)
    {
        // Set your email information
        $from = [
            'email' => $email['send_from'],
            'name' => 'Kalendar | INFOSTUD'
        ];
        $to = array($email['send_to']);
        $subject = $email['subject'];
        //  $message = 'Type your gmail message here'; // use this line to send text email.
        // load view file called "welcome_message" in to a $message variable as a html string.
        $message = $email['message'];
        // Load CodeIgniter Email library
        $this->load->library('email');
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
            // Mail sent successfully
            $this->mark_mail_as_sent($email['id']);
        }
    }

    public function mark_mail_as_sent($id)
    {
        $this->db->set('status', 'sent');
        $this->db->set('modified_at', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update('mail_queue');
    }

}