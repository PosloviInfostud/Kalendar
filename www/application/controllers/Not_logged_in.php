<?php
class Not_logged_in extends CI_controller
{
    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/not-allowed');
        $this->load->view('templates/footer');
    }

}