<?php

class Users extends CI_Controller
{
    public function index()
    {
        $this->load->view('header');
        $this->load->view('index');
    }

    public function register()
    {
        
    }

    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("email", "E-Mail", "trim|required|valid_email");
        $this->form_validation->set_rules("password", "Password", "trim|required");

        if($this->form_validation->run() == FALSE) {
            echo form_validation_errors();

        } else {
            $data = [
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password')
            ];
            $this->load->model('User_model','user');
            $this->user->login($data);
        }
    }


}