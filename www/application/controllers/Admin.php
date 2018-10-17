<?php
class Admin extends MY_Controller
{
    public function __construct()
    {
            parent::__construct();
            $this->load->model('Permission_model', 'permission');
            $this->load->model('Beautify_model', 'beautify');
            $this->load->model('Admin_model', 'admin');
            $this->permission->is_logged_in();
            $this->permission->is_admin();
    }

    public function index()
    {
        $this->layouts->set_title('Admin Dashboard');
        $this->layouts->view('admin/index');
    }

    public function show_room_reservations()
    {
        $table = [];
        $reservations = $this->admin->get_all_room_reservations();
        $table = $this->load->view('admin/room_reservations', ['reservations' => $reservations], TRUE);
        echo $table;
        die();
    }

    public function show_equipment_reservations()
    {
        $table = [];
        $reservations = $this->admin->get_all_equipment_reservations();
        $table = $this->load->view('admin/equipment_reservations', ['reservations' => $reservations], TRUE);
        echo $table;
        die();
    }

    public function show_conference_rooms()
    {
        $table = [];
        $rooms = $this->admin->get_all_rooms();
        $table = $this->load->view('admin/conference_rooms', ['rooms' => $rooms], TRUE);
        echo $table;
        die();
    }

    public function show_equipment()
    {
        $table = [];
        $equipment = $this->admin->get_all_equipment();
        $types = $this->admin->get_all_equipment_types();
        $table = $this->load->view('admin/equipment', ['equipment' => $equipment, 'types' => $types], TRUE);
        echo $table;
        die();
    }

    public function show_equipment_types()
    {
        $table = [];
        $types = $this->admin->get_all_equipment_types();
        $table = $this->load->view('admin/equipment_types', ['types' => $types], TRUE);
        echo $table;
        die();
    }

    public function show_users()
    {
        $table = [];
        $users = $this->admin->get_all_users();
        $table = $this->load->view('admin/users', ['users' => $users], TRUE);
        echo $table;
        die();
    }

    public function show_user_activites()
    {
        $table = [];
        $user_activites = $this->admin->get_all_user_activities();
        $table = $this->load->view('admin/user_activites', ['user_activites' => $user_activites], TRUE);
        echo $table;
        die();
    }

    public function show_logs()
    {
        $table = [];
        $logs = $this->admin->get_all_logs();
        $table = $this->load->view('admin/logs', ['logs' => $logs], TRUE);
        echo $table;
        die();
    }
}