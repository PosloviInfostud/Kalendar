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
        $this->load->model('User_model', 'user');
        
        $this->load->library('form_validation');
        $this->load->library('encryption');

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.',
                'is_unique' => 'This %s already exists.'
            ));
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|trim|matches[password]');

        $message = [];

        if ($this->form_validation->run() == FALSE)
        {
            $message = validation_errors();
        }
        else
        {
            $data = [
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password')
            ];
            $this->user->create($data);
            $message = 'Successful registration.';
        }
        echo $message;
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