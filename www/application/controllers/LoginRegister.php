<?php
class LoginRegister extends CI_Controller
{
    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('pages/login_reg');
        $this->load->view('templates/footer');
    }

    public function register()
    {
        $this->load->model('User_model', 'user');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('register_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('register_email', 'Email',
            'required|valid_email|is_unique[users.email]|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.',
                'is_unique' => 'This %s already exists.'
            )
        );
        $this->form_validation->set_rules('register_password', 'Password', 'required|trim');
        $this->form_validation->set_rules('register_passconf', 'Password Confirmation', 'required|trim|matches[register_password]');
        $this->form_validation->set_rules('register_bday', 'Date of Birth', 'trim');

        $data = [
            "register_name" => $this->input->post('register_name'),
            "register_email" => $this->input->post('register_email'),
            "register_password" => password_hash($this->input->post('register_password'), PASSWORD_DEFAULT),
            "register_bday" => $this->input->post('register_bday')
        ];

        $message = [];
        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            // $message = [
            //     'status' => FALSE,
            //     'status_message' => 'Submission failed! Please check the errors and try again.',
            //     'contact_name' => form_error('contact_name'),
            //     'contact_email' => form_error('contact_email'),
            //     'contact_message' => form_error('contact_message')
            // ];
        } else {
            $this->user->create($data);
            $message = 'Success! Please check your e-mail for the activation link.';
            // $this->contact->insert($data);
            // $message = [
            //     'status' => TRUE,
            //     'status_message' => 'Message successfully sent!',
            //     'contact_name' => '',
            //     'contact_email' => '',
            //     'contact_message' => ''
            // ];
        }

        echo $message;
        die();
    }

    public function login()
    {
        $this->load->model('User_model', 'user');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('login_email', 'Email', 'required|valid_email|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.'
            ));
        $this->form_validation->set_rules('login_password', 'Password', 'required|trim');

        $data = [
            "login_email" => $this->input->post('login_email'),
            "login_password" => $this->input->post('login_password')
        ];

        $message = [];
        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            // $message = [
            //     'status' => FALSE,
            //     'status_message' => 'Submission failed! Please check the errors and try again.',
            //     'contact_name' => form_error('contact_name'),
            //     'contact_email' => form_error('contact_email'),
            //     'contact_message' => form_error('contact_message')
            // ];
        } else {
            $user = $this->user->get_user_by_email($data['login_email']);
            $correct_pass = $this->user->verify_password($data['login_password'], $user['password']);

            if(empty($user)) {
                $message = 'Email is not registered!';
            } elseif(!$correct_pass) {
                $message = 'Wrong password!';
            } elseif($user['active'] === '0') {
                $message = 'User not activated!';
            } else {
                $this->user->set_session($user);
                $message = 'success';
            }

            // $this->contact->insert($data);
            // $message = [
            //     'status' => TRUE,
            //     'status_message' => 'Message successfully sent!',
            //     'contact_name' => '',
            //     'contact_email' => '',
            //     'contact_message' => ''
            // ];
        }

        echo $message;
        die();

    }

    public function logout() {
        $this->session->sess_destroy();
        url_redirect('/');
    }

    public function activate() {
        $this->load->model('User_model', 'user');
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->user->get_user_by_email($email);

        $data = [];

        if(empty($email) || empty($token) || empty($user)) {
            $data = [ 'message' => 'Invalid activation URL'];
        } else {
            $this->user->activate_user($email, $token);
            $data = [ 'message' => 'Account activated!'];
        }

        $this->load->view('templates/header');
        $this->load->view('pages/activation', $data);
        $this->load->view('templates/footer');


    }
}

// domain.com/LoginRegister/activate?email=a@a.com&token=