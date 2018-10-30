<?php

class Calendar extends MY_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Calendar_model', 'cal');
    }

    public function get_all_meetings_for_user($id)
    {
        $this->cal->get_all_meetings_for_user($id);
    }

}