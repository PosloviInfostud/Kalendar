<?php
class Reservations extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reservation_model', 'res');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('header', $this->user_data);
        $this->load->view('reservations/index');
        $this->load->view('footer');
    }

    public function create_reservation()
    {
        $this->load->view('header', $this->user_data);
        $this->load->view('reservations/create_reservation');
        $this->load->view('footer');
    }

    public function form_rooms()
    {
        $this->load->view('header', $this->user_data);
        $this->load->view('reservations/rooms');
        $this->load->view('footer');
    }

    public function form_equip()
    {
        $data['equips'] = $this->res->get_all_equipment();

        $this->load->view('header', $this->user_data);
        $this->load->view('reservations/equipment', $data);
        $this->load->view('footer');
    }

    public function search_free_rooms()
    {
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

    public function search_free_equipment()
    {
        $this->form_validation->set_rules('start_time','Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time','End Time', 'trim|required');
        //Kako da se stavi da end bude veci od start?
        $this->form_validation->set_rules('equipment_type','Type of Equipment', 'trim|required');

        if($this->form_validation->run() == false) {
            echo validation_errors();

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "type" => $this->input->post('equipment_type')
            ];
        }

        $free_equipment = $this->res->search_free_equipment($data);
        $view = $this->load->view('reservations/free_equipment',["items" => $free_equipment], true);

        echo $view;
    }

    public function submit_reservation_form()
    {
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
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('equipment_id', 'Equipment', 'trim|required');
        $this->form_validation->set_rules('description', 'Reservation Description', 'trim|required');

        if($this->form_validation->run() == false) {
            $message = validation_errors();

            echo $message;

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "equipment_id" => $this->input->post('equipment_id'),
                "description" => $this->input->post('description')
            ];

            $this->res->submit_reservation_equip_form($data);
        }
    }

    public function show_room_reservations()
    {
        $table = [];
        $room_res = $this->res->get_room_reservations_by_user($this->user_data['user']['id']);
        $table = $this->load->view('admin/room_reservations', ['room_res' => $room_res], TRUE);
        echo $table;
        die();
    }

    public function show_equipment_reservations()
    {
        $table = [];
        $room_res = $this->res->get_room_reservations_by_user($this->user_data['user']['id']);
        $table = $this->load->view('admin/room_reservations', ['room_res' => $room_res], TRUE);
        echo $table;
        die();
    }

    public function room_reservations_by_user()
    {
        $meetings = $this->res->room_reservations_by_user($this->user_data['user']['id']);
        $this->load->view('header', $this->user_data);
        $this->load->view('reservations/user_meetings', ['meetings' => $meetings]);
        $this->load->view('footer');
    }

    public function get_reservation_members()
    {
        $reservation_id = $this->input->post('reservation_id');
        $members = $this->res->get_reservation_members($reservation_id);
        $modal = $this->load->view('reservations/members_modal', ['members' => $members], TRUE);
        echo $modal;
        die();
    }

    public function equipment_reservations_by_user()
    {
        $equipment = $this->res->equipment_reservations_by_user($this->user_data['user']['id']);
        $this->load->view('header', $this->user_data);
        $this->load->view('reservations/user_equipment', ['equipment' => $equipment]);
        $this->load->view('footer');
    }
}