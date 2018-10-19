<?php
class Task_scheduler extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reminder_model', 'reminder');
        $this->load->model('Reservation_model', 'res');
        $this->load->model('Mail_model', 'mail');
        $this->load->model('Beautify_model', 'beautify');
    }

    // Task:        Check for upcoming meetings an send a reminder 
    // Scheduled:   every minute

    public function upcoming_meetings()
    {
        // Get upcoming meeting details
        $meetings = $this->reminder->get_upcoming_meetings();
        // Add memmbers
        $extended_meetings = $this->reminder->include_meeting_members($meetings);
        // Add emails to the queue
        $this->reminder->notify_members_of_upcoming_meeting($extended_meetings);
        // Update db
        $this->reminder->mark_meetings_as_sent($meetings);
    }


    // Task:        Get set number of emails from the mail queue and send them
    // Scheduled:   every minute

    public function send_pending_mails()
    {
        $pending_emails = $this->mail->get_pending_mails();
        $this->mail->send_pending_mails($pending_emails);
    }
}