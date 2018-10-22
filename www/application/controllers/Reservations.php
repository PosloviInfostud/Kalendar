<?php
class Reservations extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Permission_model', 'permission');
        $this->permission->is_logged_in();
        $this->load->model('Reservation_model', 'res');
        $this->load->model('Mail_model', 'mail');
        $this->load->model('Beautify_model', 'beautify');
        $this->load->model('Logs_model', 'logs');
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->helper('link_helper');
    }

    public function index()
    {
        $this->layouts->set_title('Reservations');
        $this->layouts->view('reservations/index');
    }

    public function create_reservation()
    {
        $this->layouts->set_title('Make a New Reservation');
        $this->layouts->view('reservations/create_reservation');
    }

    public function form_rooms()
    {
        $this->layouts->set_title('Room Reservation');
        $this->layouts->view('reservations/rooms');
    }

    public function form_specific_room()
    {
        $this->load->model('Admin_model','admin');
        $rooms = $this->admin->get_all_rooms();
        $this->layouts->set_title('Room Reservation');
        $this->layouts->view('reservations/specific_room', ["rooms" => $rooms]);
    }

    public function form_equip()
    {
        $data['equips'] = $this->res->get_all_equipment_types();
        $this->layouts->set_title('Equipment Reservation');
        $this->layouts->view('reservations/equipment', $data);
    }

    public function form_specific_equip()
    {
        $this->load->model('Admin_model','admin');
        $equipment = $this->admin->get_all_equipment();
        $this->layouts->set_title('Item Reservation');
        $this->layouts->view('reservations/specific_equipment',["equipment" => $equipment]);
    }

    public function search_free_rooms()
    {
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        //Kako da se stavi da end bude veci od start?
        $this->form_validation->set_rules('attendants', 'Number of Participants', 'trim|greater_than_equal_to[2]|less_than_equal_to[50]|integer');

        if($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $attendants = $this->input->post('attendants');
            if(empty($attendants)) {
                $attendants = 2;
            }

            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "attendants" => $attendants
            ];

            $rooms = $this->res->check_free_rooms($data);
            $users = $this->res->show_users_for_invitation();

            $view = $this->load->view('reservations/free_rooms', ["rooms" => $rooms, "users" => $users], true);

            echo $view;
        }
    }

    public function load_calendar_for_room()
    {
        $data['room_id'] = $this->input->post('room');
        $data['users'] = $this->res->show_users_for_invitation();

        $view = $this->load->view('reservations/load_calendar_for_room', $data, true);

        echo $view;
    }

    public function load_calendar_for_item()
    {
        $data['equipment_id'] = $this->input->post('equipment_id');

        $view = $this->load->view('reservations/load_calendar_for_item', $data, true);

        echo $view;
    }

    public function search_free_termins_for_specific_room()
    {
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        //Kako da se stavi da end bude veci od start?
        $this->form_validation->set_rules('room_id', 'Room', 'trim');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "room_id" => $this->input->post('room_id')
            ];

        $free = $this->res->check_if_room_is_free($data);

        echo $free;
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
            $free_equipment = $this->res->search_free_equipment($data);
            $view = $this->load->view('reservations/free_equipment',["items" => $free_equipment], true);
            
            echo $view;
        }
    }

    public function submit_reservation_form()
    {
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('attendants', 'Number of Participants', 'trim|greater_than_equal_to[2]|less_than_equal_to[50]|integer');
        $this->form_validation->set_rules('room', 'Room', 'trim|required');
        $this->form_validation->set_rules('title', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Event Description', 'trim');
        $this->form_validation->set_rules('members[]', 'Attendants', 'trim|required|valid_emails');
        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "room" => $this->input->post('room'),
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description'),
                "members" => $this->input->post('members')
            ];
            if($this->res->check_if_room_is_free($data)) {
                $this->res->submit_reservation_form($data);
                $message['success'] = "success";

            } else {
                $message['error'] = "Did you change termin? Please, search again free conference rooms according to your time!";
            }

        }
        echo json_encode($message);
    }

    public function submit_reservation_equip_form()
    {
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('equipment_id', 'Equipment', 'trim|required');
        $this->form_validation->set_rules('description', 'Reservation Description', 'trim|required');

        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "equipment_id" => $this->input->post('equipment_id'),
                "description" => $this->input->post('description')
            ];
            if($this->res->check_if_equipment_is_free($data)) {
                $this->res->submit_reservation_equip_form($data);
                $message['success'] = "success";
                            
            } else {
                $message['error'] = "Did you change termin? Please, search again free equipment according to your time!";
            }

        }
        echo json_encode($message);
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
        $this->layouts->set_title('Active Reservations');
        $this->layouts->view('reservations/user_meetings', ['meetings' => $meetings]);
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
        $equipment = $this->res->equipment_reservations_by_user([$this->user_data['user']['id']]);
        $this->layouts->set_title('Active Reservations');
        $this->layouts->view('reservations/user_equipment', ['equipment' => $equipment]);
    }

    public function single_room_reservation($id)
    {
        $meeting = $this->res->single_room_reservation($id);
        // Check if a reservation exists with that id
        if(empty($meeting)) {
            url_redirect('/error_404');
        }
        $members = $this->res->get_reservation_members($id);
        $user_id = $this->user_data['user']['id'];

        // Check if user is a member of the given reservation
        $this->permission->is_member_of_reservation($members, $user_id);

        // Build and load view
        $data = [
            'meeting' => $meeting[0],
            'members' => $members,
            'user_id' => $user_id
        ];
        $this->layouts->set_title($meeting[0]['title']);
        $this->layouts->view('reservations/meetings/single_view', $data);
    }

    public function single_equipment_reservation($id)
    {
        $user_id = $this->user_data['user']['id'];
        $equipment = $this->res->single_equipment_reservation($id);
        // Check if reservation exists for that id
        if(empty($equipment)) {
            url_redirect('/error_404');
        // Check if it's the user's reservation
        } elseif($equipment[0]['user_id'] != $user_id) {
            echo 'Not your reservation.';
            die();
        }
        $this->layouts->set_title($equipment[0]['item_name'] . ' Reservation');
        $this->layouts->view('reservations/equipment/single_view', ['equipment' => $equipment[0], 'user_id' => $user_id]);
    }

    public function update_room_reservation_form($id)
    {
        $meeting = $this->res->single_room_reservation($id);
        // Check if a reservation exists with that id
        if(empty($meeting)) {
            url_redirect('/error_404');
        }
        $members = $this->res->get_reservation_members($id);
        $this->load->model('Admin_model','admin');
        $rooms = $this->admin->get_all_rooms();
        $user_id = $this->user_data['user']['id'];

        // Check if user is a member of the given reservation
        $this->permission->is_member_of_reservation($members, $user_id);
        $this->load->view('header', $this->user_data);
        $this->load->view('reservations/meetings/update_room_reservation_form', ['meeting' => $meeting[0], 'members' => $members, 'user_id' => $user_id, 'rooms' => $rooms]);
        $this->load->view('footer');
    }

    public function show_update_user_role_form()
    {
        $data['user_id'] = $this->input->post('user_id');
        $data['res_id'] = $this->input->post('res_id');
        $data['name'] = $this->input->post('name');
        $data['role_id'] = $this->input->post('role_id');
        $data['role_name'] = $this->input->post('role_name');
        $data['creator'] = $this->input->post('creator');

        $view = $this->load->view('reservations/meetings/update_user_role', $data, true);

        echo $view;
    }

    public function update_user_role()
    {
        $data['user_id'] = $this->input->post('user_id');
        $data['res_id'] = $this->input->post('res_id');
        $data['role_id'] = $this->input->post('res_role_id');
        $data['creator'] = $this->input->post('creator');
        $this->res->update_user_role($data);
    }

    public function delete_res_member()
    {
        $data['res'] = $this->input->post('res_id');
        $data['member'] = $this->input->post('user_id');
        $data['creator'] = $this->input->post('creator');
        $this->res->delete_res_member($data);
    }

    public function show_add_new_member_form()
    {
        $data['res_id'] = $this->input->post('res_id');
        $data['users'] = $this->res->get_users_not_res_members($data['res_id']);
        $view = $this->load->view('reservations/meetings/add_new_member_form', $data, true);

        echo $view;
    }

    public function add_new_member()
    {
        $data['members'] = $this->input->post('members');
        $data['res_id'] = $this->input->post('res_id');
        $data['admin'] = $this->user_data['user']['id'];
        $data = $this->res->check_members_reg($data);
        $data = $this->res->check_if_member_already_invited($data);
        $this->res->insert_unregistered_members($data);
        $this->res->invite_unregistered_members($data['res_id']);
        $this->res->insert_reservation_members($data);
        $this->res->invite_members($data['res_id']);
    }

    public function update_room_reservation()
    {
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('room', 'Room', 'trim|required');
        $this->form_validation->set_rules('title', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Event Description', 'trim');
        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "room" => $this->input->post('room'),
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description'),
                "id" => $this->input->post('res')
            ];
            if($this->res->check_if_room_is_free_for_update($data)) {
                $this->res->update_room_reservation($data);
                $message['success'] = $data['id'];

            } else {
                $message['error'] = "Did you change termin? Please, search again free conference rooms according to your time!";
            }

        }
        echo json_encode($message);    }

    public function delete_room_reservation($id)
    {
        $this->res->delete_room_reservation($id);
        url_redirect('/dashboard');
    }

    public function show_update_equip_form()
    {
        $id = $this->input->post('equip');
        $data['equipment'] = $this->res->single_equipment_reservation($id)[0];
        $view = $this->load->view('reservations/equipment/update_equip_form', $data, true);

        echo $view;
    }

    public function update_equipment()
    {
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');

        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "equip_id" => $this->input->post('equip_id'),
                "res_id" => $this->input->post('res_id'),
                "description" => $this->input->post('description')
            ];
            if($this->res->check_if_equipment_is_free_for_update($data)) {
                $this->res->update_equip($data);
                $message['success'] = $data['res_id'];
                            
            } else {
                $message['error'] = "Did you change termin? Please, search again free equipment according to your time!";
            }

        }
        echo json_encode($message); 
    }

    public function delete_equipment_reservation($id)
    {
        $this->res->delete_equipment_reservation($id);
        url_redirect('/reservations/equipment');
    }
}