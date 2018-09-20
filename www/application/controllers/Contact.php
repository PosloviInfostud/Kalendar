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

        $this->form_validation->set_rules('contact_name', 'Name', 'required|trim');
        $this->form_validation->set_rules(
            'contact_email',
            'Email',
            'required|valid_email|is_unique[contacts.email]|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.',
                'is_unique' => 'This %s already exists.'
            )
        );
        $this->form_validation->set_rules('contact_message', 'Message', 'required|trim');

        $data = $this->input->post('form_data');

        $message = [];
        if ($this->form_validation->run() == false) {
            // $message = validation_errors();
            $message = [
                'status' => false,
                'status_message' => 'Submission failed! Please check the errors and try again.',
                'contact_name' => form_error('contact_name'),
                'contact_email' => form_error('contact_email'),
                'contact_message' => form_error('contact_message')
            ];
        } else {
            $this->contact->insert($data);
            $message = [
                'status' => true,
                'status_message' => 'Message successfully sent!',
                'contact_name' => '',
                'contact_email' => '',
                'contact_message' => ''
            ];
        }

        echo json_encode($message);
        die();

    }
}