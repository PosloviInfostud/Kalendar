<?php
class Reservations extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reservation_model', 'res');
        $this->load->model('User_model', 'user');
    }

    public function create_reservation()
    {
        $this->load->view('header');
        $this->load->view('reservations/create_reservation');
        $this->load->view('footer');
    }

    public function form_rooms()
    {
        $this->load->view('header');
        $this->load->view('reservations/rooms');
        $this->load->view('footer');
    }

    public function form_equip()
    {
        $data['equips'] = $this->res->get_all_equipment();

        $this->load->view('header');
        $this->load->view('reservations/equipment', $data);
        $this->load->view('footer');
    }

    public function search_free_rooms()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        //Kako da se stavi da end bude veci od start?
        $this->form_validation->set_rules('attendants', 'Number of Participants', 'trim|required|greater_than_equal_to[2]|less_than_equal_to[50]|integer');

        if($this->form_validation->run() == false) {
            $message = validation_errors();

            echo $message;

        } else {

            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "attendants" => $this->input->post('attendants')
            ];

            $rooms = $this->res->check_free_rooms($data);
            $users = $this->res->show_users_for_invitation();

            $view = $this->load->view('reservations/free_rooms', ["rooms" => $rooms, "users" => $users], true);

            echo $view;
        }
    }

    public function submit_reservation_form()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('attendants', 'Number of Participants', 'trim|required|greater_than_equal_to[2]|less_than_equal_to[50]|integer');
        $this->form_validation->set_rules('room', 'Room', 'trim|required');
        $this->form_validation->set_rules('title', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Event Description', 'trim|required');
        $this->form_validation->set_rules('members[]', 'Attendants', 'trim|required');

        if($this->form_validation->run() == false) {
            $message = validation_errors();

            echo $message;

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "room" => $this->input->post('room'),
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description'),
                "members" => $this->input->post('members')
            ];

            $this->res->submit_reservation_form($data);

        }
    }

    public function submit_reservation_equip_form()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('item', 'Equipment', 'trim|required');
        $this->form_validation->set_rules('title', 'Reservation Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Reservation Description', 'trim|required');

        if($this->form_validation->run() == false) {
            $message = validation_errors();

            echo $message;

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "item" => $this->input->post('item'),
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description')
            ];

            $this->res->submit_reservation_equip_form($data);
        }
    }
}