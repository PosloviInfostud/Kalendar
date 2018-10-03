<?php
class Admin extends CI_Controller
{
    public function index()
    {

        $this->load->view('header');
        $this->load->view('admin/index');
        $this->load->view('footer');
    }

    public function show_view()
    {
        $this->load->model('Admin_model', 'admin');

        // get data from ajax
        $option = $this->input->post('name');
        $table = [];

        $reservations = $this->admin->get_all_reservations();
        $users = $this->admin->get_all_users();
        $user_activites = $this->admin->get_all_user_activities();
        $logs = $this->admin->get_all_logs();

        // send view to ajax based on the clicked button
        if($option == 'reservations') {
            $table = $this->load->view('admin/reservations', ['reservations' => $reservations], TRUE);
        } elseif($option == 'users') {
            $table = $this->load->view('admin/users', ['users' => $users], TRUE);
        } elseif($option == 'user-activites') {
            $table = $this->load->view('admin/user_activites', ['user_activites' => $user_activites], TRUE);
        } elseif($option == 'logs') {
            $table = $this->load->view('admin/logs', ['logs' => $logs], TRUE);
        }

        echo $table;
        die();
    }
}