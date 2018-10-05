<?php
class Admin extends CI_Controller
{
    public function index()
    {
        $this->load->view('header');
        $this->load->view('admin/index');
        $this->load->view('footer');
    }

    public function show_reservations()
    {
        $this->load->model('Admin_model', 'admin');
        $table = [];
        $reservations = $this->admin->get_all_reservations();
        $table = $this->load->view('admin/reservations', ['reservations' => $reservations], TRUE);
        echo $table;
        die();
    }

    public function show_items()
    {
        $this->load->model('Admin_model', 'admin');
        $table = [];
        $items_data = [
            'items' => $this->admin->get_all_res_items(),
            'types' => $this->admin->get_all_res_types()
        ];
        $table = $this->load->view('admin/items', $items_data, TRUE);
        echo $table;
        die();
    }

    public function show_users()
    {
        $this->load->model('Admin_model', 'admin');
        $table = [];
        $users = $this->admin->get_all_users();
        $table = $this->load->view('admin/users', ['users' => $users], TRUE);
        echo $table;
        die();
    }

    public function show_user_activites()
    {
        $this->load->model('Admin_model', 'admin');
        $table = [];
        $user_activites = $this->admin->get_all_user_activities();
        $table = $this->load->view('admin/user_activites', ['user_activites' => $user_activites], TRUE);
        echo $table;
        die();
    }

    public function show_logs()
    {
        $this->load->model('Admin_model', 'admin');
        $table = [];
        $logs = $this->admin->get_all_logs();
        $table = $this->load->view('admin/logs', ['logs' => $logs], TRUE);
        echo $table;
        die();
    }
}