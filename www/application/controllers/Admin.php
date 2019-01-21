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
        $this->layouts->view('admin/index', array(), ('admin_tailwind'));
    }

    public function meetings()
    {
        $reservations = $this->admin->get_all_room_reservations();
        $this->layouts->view('admin/room_reservations', ['reservations' => $reservations], ('admin_tailwind'));
    }

    public function equipment()
    {
        $reservations = $this->admin->get_all_equipment_reservations();
        $this->layouts->view('admin/equipment_reservations', ['reservations' => $reservations], ('admin_tailwind'));
    }

    public function conference_rooms()
    {
        $rooms = $this->admin->get_all_rooms();
        $this->layouts->view('admin/conference_rooms', ['rooms' => $rooms], ('admin_tailwind'));
    }

    public function items()
    {
        $equipment = $this->admin->get_all_equipment();
        $types = $this->admin->get_all_equipment_types();
        $this->layouts->view('admin/equipment', ['equipment' => $equipment, 'types' => $types], ('admin_tailwind'));
    }

    public function types()
    {
        $types = $this->admin->get_all_equipment_types();
        $this->layouts->view('admin/equipment_types', ['types' => $types], ('admin_tailwind'));
    }

    public function users()
    {
        $users = $this->admin->get_all_users();
        $this->layouts->view('admin/users', ['users' => $users], ('admin_tailwind'));
    }

    public function activities()
    {
        $user_activites = $this->admin->get_all_user_activities();
        $this->layouts->view('admin/user_activites', ['user_activites' => $user_activites], ('admin_tailwind'));
    }

    public function logs()
    {
        $logs = $this->admin->get_all_logs();
        $this->layouts->view('admin/logs', ['logs' => $logs], ('admin_tailwind'));
    }
}