<?php
class Reminders extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reminder_model', 'reminder');
        $this->load->model('Reservation_model', 'res');
        $this->load->model('Beautify_model', 'beautify');
    }

    public function upcoming_meetings()
    {
        // Get upcoming meeting details
        $meetings = $this->reminder->get_upcoming_meetings();
        // Add memmbers
        $ext_meetings = $this->reminder->include_meeting_members($meetings);
        // Send email
        $this->reminder->notify_members_of_upcoming_meeting($ext_meetings);
        // Update db
        $this->reminder->mark_meetings_as_sent($meetings);
    }
}