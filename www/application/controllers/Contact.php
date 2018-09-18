<?php
class Contact extends CI_Controller
{
    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('pages/contact');
        $this->load->view('templates/footer');
    }

    public function process_form()
    {
        $this->load->model('Contact_model', 'contact');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('contact-name', 'Name', 'required');
        $this->form_validation->set_rules('contact-email', 'Email', 'required');
        $this->form_validation->set_rules('contact-message', 'Message', 'required');

        $data = $this->input->post('form_data');
        $this->contact->insert($data);

        if ($this->form_validation->run() == FALSE)
                {
                    echo validation_errors();
                }

    }
}