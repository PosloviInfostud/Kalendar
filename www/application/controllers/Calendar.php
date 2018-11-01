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
    
    public function get_all_meetings_for_room($id) 
    {
        $this->cal->get_all_meetings_for_room($id);
    }

    public function save_test()
    {
        var_dump($this->input->post('title'));
        var_dump($this->input->post('start_time'));
        var_dump($this->input->post('end_time'));

    }

}