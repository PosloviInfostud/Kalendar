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
        $this->layouts->add_header_include('/scripts/fullcalendar/fullcalendar.min.css');
        $this->layouts->add_footer_include('/scripts/fullcalendar/lib/moment.min.js');
        $this->layouts->add_footer_include('/scripts/fullcalendar/fullcalendar.min.js');
        $this->layouts->add_footer_include('/scripts/fullcalendar/locale/sr.js');
        $this->layouts->add_footer_include('/scripts/fullcalendar/gcal.js');
        // $this->layouts->add_footer_include('/js/calendar.js');
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
        $date = date('Y-m-d h:i:s', time());

        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('attendants', 'Number of Participants', 'trim|greater_than_equal_to[2]|less_than_equal_to[50]|integer');

        if ($this->form_validation->run())
        {
            // Check for user errors
            $response['status'] = 'user_error';

            if($this->input->post('start_time') < $date)
            {
                $response['errors'] = "Change start time. You have to reserve in advance";
            }
            elseif($this->input->post('start_time') >= $this->input->post('end_time'))
            {
                $response['errors'] = "Check start and end time again. End time has to be greater than start time.";
            }
            else
            {
                // When everything looks OK
                $response['status'] = 'success';
                $attendants = $this->input->post('attendants');

                if(empty($attendants)) {
                    $attendants = 2;
                }

                $data = [
                    "start_time" => $this->input->post('start_time'),
                    "end_time" => $this->input->post('end_time'),
                    "attendants" => $attendants
                ];

                $frequencies = $this->res->get_reservation_frequencies();
                $rooms = $this->res->check_free_rooms($data);
                $users = $this->res->show_users_for_invitation();

                $response['message'] = $this->load->view('reservations/free_rooms', ["rooms" => $rooms, "users" => $users, "frequencies" => $frequencies], true);
            }
        }
        else
        {
            // Form errors
            $response['status'] = 'form_error';
            $response['errors'] = validation_errors();
        }
        header('Content-type: application/json');
        echo json_encode($response);
        exit();
    }

    public function load_calendar_for_room()
    {
        $this->load->model('calendar_model', 'calendar');
        $data['room_id'] = $this->input->post('room');
        $data['users'] = $this->res->show_users_for_invitation();
        $data['frequencies'] = $this->res->get_reservation_frequencies();
        $data['current_reservations'] = $this->calendar->get_all_meetings_for_room($data['room_id']);
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
        $date = date('Y-m-d h:i:s', time());

        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('room_id', 'Room', 'trim');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
            die;
        } 
        if($this->input->post('start_time') < $date) {
                echo "Change start time. You have to reserve in advance";
        } 
        elseif($this->input->post('start_time') >= $this->input->post('end_time')) {
            echo "Check start and end time again. End time has to be greater than start time.";

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
        $date = date('Y-m-d h:i:s', time());

        $this->form_validation->set_rules('start_time','Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time','End Time', 'trim|required');
        $this->form_validation->set_rules('equipment_type','Type of Equipment', 'trim|required');

        if($this->form_validation->run() == false) {
            echo validation_errors();
            die;
        } 
        if($this->input->post('start_time') < $date) {
                echo "Change start time. You have to reserve in advance";
        } 
        elseif($this->input->post('start_time') >= $this->input->post('end_time')) {
            echo "Check start and end time again. End time has to be greater than start time.";

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
        $this->load->model('Datetime_model', 'datetime');
        $date = date('Y-m-d h:i:s', time());

        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('attendants', 'Number of Participants', 'trim|greater_than_equal_to[2]|less_than_equal_to[50]|integer');
        $this->form_validation->set_rules('room', 'Room', 'trim|required');
        $this->form_validation->set_rules('frequency', 'Frequency', 'required');
        $this->form_validation->set_rules('title', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Event Description', 'trim');
        $this->form_validation->set_rules('members[]', 'Attendants', 'trim|required|valid_emails');

        ////////////////////////////////////////////////////////////////////////////////////////////

        // if ($this->form_validation->run()) {
        //     $data = [
        //         "start_time" => $this->input->post('start_time'),
        //         "end_time" => $this->input->post('end_time'),
        //         "frequency" => $this->input->post('frequency'),
        //         "room" => $this->input->post('room'),
        //         "title" => $this->input->post('title'),
        //         "description" => $this->input->post('description'),
        //         "members" => $this->input->post('members')
        //     ];

        //     if($this->res->check_if_room_is_free($data)) {
        //         $this->res->submit_reservation_form($data);
        //         $response['status'] = "success";
        //     } else {
        //         $response['status'] = "user_error";
        //         $response['errors'] = "Unfortunately, the room is not available at that time! Check again.";
        //     }
        // } else {
        //     $errors = array();
        //     // Loop through $_POST and get the keys
        //     foreach ($this->input->post() as $key => $value) {
        //         // Add the error message for this field
        //         $errors[] = $value;
        //     }
        //     $response['errors'] = validation_errors();
        //     $response['status'] = 'form_error';
        //     // $errors = array();
        //     // // Loop through $_POST and get the keys
        //     // foreach ($this->input->post() as $key => $value) {
        //     //     // Add the error message for this field
        //     //     $errors[$key] = form_error($key);
        //     // }
        //     // $response['errors'] = array_filter($errors); // Some might be empty
        //     // $response['status'] = 'form_error';
        // }
        // header('Content-type: application/json');
        // echo json_encode($response);
        // exit();

        ////////////////////////////////////////////////////////////////////////////////////////////

        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();
        } 
        elseif($this->input->post('start_time') < $date) {
            $message['error'] = "Change start time. You have to reserve in advance";
        } 
        elseif($this->input->post('start_time') >= $this->input->post('end_time')) {
            $message['error'] = "Check start and end time again. End time has to be greater than start time.";

        } else {
            $data = [
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "frequency" => $this->input->post('frequency'),
                "room" => $this->input->post('room'),
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description'),
                "members" => $this->input->post('members')
            ];
            if($this->res->check_if_room_is_free($data)) {
                $this->res->submit_reservation_form($data);
                $message['success'] = "success";

            } else {
                $message['error'] = "Unfortunately, the room is not available at that time! Check again.";
            }

        }
        echo json_encode($message);
    }

    public function submit_reservation_equip_form()
    {
        $date = date('Y-m-d h:i:s', time());

        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('equipment_id', 'Equipment', 'trim|required');
        $this->form_validation->set_rules('description', 'Reservation Description', 'trim|required');

        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();

        } elseif($this->input->post('start_time') < $date) {
            $message['error'] = "Change start time. You have to reserve in advance";
        }
        elseif($this->input->post('start_time') >= $this->input->post('end_time')) {
            $message['error'] = "Check start and end time again. End time has to be greater than start time.";
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
                $message['error'] = "Unfortunately, the item is not available at that time! Check again.";
            }
        }
        echo json_encode($message);
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
        $child_dates = [];

        $meeting = $this->res->single_room_reservation($id);
        // Check if a reservation exists with that id
        if(empty($meeting)) {
            url_redirect('/error_404');
        }
        $members = $this->res->get_reservation_members($id);
        $user_id = $this->user_data['user']['id'];
        $editors = $this->res->get_all_editors($id);
        $notify = $this->res->get_if_member_is_notified($id, $user_id);

        if($meeting[0]['recurring'] == 1) {
            $child_dates = $this->res->get_child_reservations($meeting[0]['parent']);
        }

        // Check if user is a member of the given reservation
        $this->permission->is_member_of_reservation($members, $user_id);

        // Build and load view
        $data = [
            'meeting' => $meeting[0],
            'members' => $members,
            'user_id' => $user_id,
            'editors' => $editors,
            'child_dates' => $child_dates,
            'notify' => $notify
        ];
        $this->layouts->set_title($meeting[0]['title']);
        $this->layouts->add_footer_include('/js/reservations.js');
        $this->layouts->view('reservations/meetings/single_view_tailwind', $data, 'master_tailwind');
        // $this->layouts->view('reservations/meetings/single_view', $data);
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

        // Check if user is an editor of the given reservation
        $this->permission->is_editor_of_reservation($id, $user_id);
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
        $this->res->invite_new_members($data['res_id'], $data['registered']);
    }

    public function update_room_reservation()
    {
        $this->load->model('Datetime_model', 'datetime');
        $date = date('Y-m-d h:i:s', time());
        
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $this->form_validation->set_rules('room', 'Room', 'trim|required');
        $this->form_validation->set_rules('title', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Event Description', 'trim');

        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();
        } 
        elseif($this->input->post('start_time') < $date) {
            $message['error'] = "Change start time. You have to reserve in advance";
        } 
        elseif($this->input->post('start_time') >= $this->input->post('end_time')) {
            $message['error'] = "Check start and end time again. End time has to be greater than start time.";

        } else {
            $data = [
                "default_start_time" => $this->input->post('default_start_time'),
                "default_end_time" => $this->input->post('default_end_time'),
                "start_time" => $this->input->post('start_time'),
                "end_time" => $this->input->post('end_time'),
                "room" => $this->input->post('room'),
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description'),
                "id" => $this->input->post('res'),
                "update_all" => $this->input->post('update_all'),
                "parent" => $this->input->post('parent')
            ];

            if($data['update_all'] == 'true') {
                // Update children
                $child_data = $data;
                $active_child = $data['id'];
                // Get all children
                $children = $this->res->get_child_reservations($data['parent']);
                // Get date differences
                $start_time_diff = $this->datetime->time_difference($data['default_start_time'], $data['start_time']);
                $end_time_diff = $this->datetime->time_difference($data['default_end_time'], $data['end_time']);
                // Loop through the children
                foreach($children as $key => $child) {
                    // Prepare data for update
                    $child_data['id'] = $child['id'];
                    $child_data['start_time'] = $this->datetime->add_time($child['start_time'], $start_time_diff);
                    $child_data['end_time'] = $this->datetime->add_time($child['end_time'], $end_time_diff);
                    // Update child
                    $this->res->update_room_reservation($child_data);
                    $message['success'] = $active_child;
                }
                // Update parent
                $parent_data = $data;
                $parent = $this->res->single_room_reservation($data['parent']);
                $parent_data['id'] = $parent[0]['id'];
                // Prepare data for update
                $parent_data['start_time'] = $this->datetime->add_time($parent[0]['starttime'], $start_time_diff);
                $parent_data['end_time'] = $this->datetime->add_time($parent[0]['endtime'], $end_time_diff);
                $this->res->update_room_reservation($parent_data);
            } else {
                if($this->res->check_if_room_is_free_for_update($data)) {
                    $this->res->update_room_reservation($data);
                    $message['success'] = $data['id'];
                } else {
                    $message['error'] = "Unfortunately, the room is not available at that time! Check again.";
                }
            }
        }
        echo json_encode($message);
    }

    public function delete_room_reservation($id)
    {
        // Delete all reservations of a recurring event
        if($this->input->get('option', TRUE)) {
            // Get parent id
            $parent = $this->input->get('parent', TRUE);
            // Delete children
            $children = $this->res->get_child_reservations($parent);
            foreach($children as $child) {
                $this->res->delete_room_reservation($child['id'], TRUE);
            }
            // Delete parent
            $this->res->delete_room_reservation($parent);

        // Delete single reservation
        } else {
            $this->res->delete_room_reservation($id);
        }
        url_redirect('/reservations/meetings');
    }

    public function show_update_equip_form($id)
    {
        $user_id = $this->user_data['user']['id'];
        $data['equipment'] = $this->res->single_equipment_reservation($id)[0];
        // Check if reservation exists for that id
        if(empty($data['equipment'])) {
            url_redirect('/error_404');
        // Check if it's the user's reservation
        } elseif($data['equipment']['user_id'] != $user_id) {
            echo 'Not your reservation.';
            die();
        }        
        $this->layouts->view('reservations/equipment/update_equip_form', $data);
    }

    public function update_equipment()
    {
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');

        if($this->form_validation->run() == false) {
            $message['error'] = validation_errors();

        } elseif($this->input->post('start_time') >= $this->input->post('end_time')) {
            $message['error'] = "Check start and end time again. End time has to be greater than start time.";

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
                $message['error'] = "Unfortunately, the item is not available at that time! Check again.";
            }

        }
        echo json_encode($message); 
    }

    public function delete_equipment_reservation($id)
    {
        $this->res->delete_equipment_reservation($id);
        url_redirect('/reservations/equipment');
    }

    public function change_member_notifications()
    {
        $user_id = $this->input->post('user_id');
        $notify = $this->input->post('value');
        $column = $this->input->post('column');
        $res_id = $this->input->post('res_id');
        $this->res->change_member_notifications($user_id, $res_id, $notify, $column);
    }
}