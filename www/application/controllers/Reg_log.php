<?php
class Reg_log extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Mail_model', 'mail');
        $this->load->model('Logs_model', 'logs');
        $this->load->model('Permission_model', 'permission');
    }

    public function index()
    {
        $token = $this->input->cookie('usr-vezba');
        $user = $this->user->get_user_by_token($token);

        if(empty($token) || empty($user)) {
            $this->layouts->set_title('Reservations');
            $this->layouts->view('index', array(), 'login_tailwind');
        } else {
            url_redirect('/rezervacije/sastanci');
        }
    }

    public function register()
    {
        $response = $this->user->register();
        header('Content-type: application/json');
        echo json_encode($response);
        exit();
    }

    public function activate()
    {
        $data = [
            "email" => $this->input->get('email'),
            "activation_key" => $this->input->get('token')
        ];

        $user = $this->user->get_user_by_email($data['email']);

        if (empty($user)) {
            // Check if email is registered
            $msg = $this->alerts->render('red', 'Attention', 'Neispravan aktivacioni kod. Pokušaj ponovo.');
            $this->session->set_flashdata('flash_message', $msg);
        } elseif ($data['email'] == $user['email'] && $data['activation_key'] == $user['activation_key']) {
            // Check if both values match
            $this->user->activate($user['id']);
        } else {
            // Handle invalid activation link
            $msg = $this->alerts->render('red', 'Attention', 'Neispravan aktivacioni kod. Pokušaj ponovo.');
            $this->session->set_flashdata('flash_message', $msg);
        }
        url_redirect('/');
    }

    public function login()
    {
        $this->form_validation->set_rules("email", "E-Mail", "trim|required|valid_email",
            array(  'required' => 'Email adresa je obavezna.',
                    'valid_email' => 'Email adresa nije pravilno napisana.'));
        $this->form_validation->set_rules("password", "Password", "trim|required",
            array(  'required' => 'Šifra je obavezna.'));
        if ($this->form_validation->run()) {
            $data = [
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password')
            ];
            $message = $this->user->login($data);
            $response['status'] = $message['status'];
            $response['errors'] = $message['error'];
        } else {
            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }
            $response['errors'] = array_filter($errors); // Some might be empty
            $response['status'] = 'form_error';

            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $response);
        }
        // You can use the Output class here too
        header('Content-type: application/json');
        echo json_encode($response);
        exit();
    }
    public function send_forgot_password_mail()
    {
        $this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email',
            array(  'required' => 'Email adresa je obavezna.',
                    'valid_email' => 'Email adresa nije pravilno napisana.'));

        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            if (empty($this->user->get_user_by_email($email))) {
                $response['status'] = 'user_error';
                $response['errors'] = "Ne postoji registrovan član sa postojećom email adresom.";
            } else {
                $this->load->library('encryption');
                $code = bin2hex($this->encryption->create_key(16));
                $expire = date('Y-m-d h:i:s', strtotime('+5 days'));
                $this->user->set_reset_key($email, $code, $expire);

                // Prepare mail
                $this->load->helper('link_helper');
                $password_link = reset_password_link($email, $code);

                $email_details = [];
                $email_details['from'] = 'visnjamarica@gmail.com';
                $email_details['subject'] = 'Resetovanje šifre';
                $email_details['message'] = $this->load->view('mails/reset_password_mail', ['password_link' => $password_link], true);
                
                // Add email to queue
                $this->mail->add_mail_to_queue(array($email), $email_details);

                // Set status to success
                $response['status'] = 'success';

                // Notification
                $msg = $this->alerts->render('teal', 'Uspešno poslat email', 'Kada dobiješ email, klikni na link unutar njega i ispuni formu sa novom šifrom.');
                $this->session->set_flashdata('flash_message', $msg);
            }
        } else {
            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }
            $response['errors'] = array_filter($errors); // Some might be empty
            $response['status'] = 'form_error';

            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $response);
        }
        header('Content-type: application/json');
        echo json_encode($response);
        exit();
    }

    public function reset_password_form()
    {
        $data = [
            'email' => $this->input->get('email'),
            'code' => $this->input->get('code')
        ];

        // Check for incorrect activation link
        if($this->user->check_reset_token($data) == false || $data['code'] == "") {
            // Notification
            $msg = $this->alerts->render('red', 'Pažnja', 'Email adresa i kod ne odgovaraju. Pokušaj ponovo.');
            $this->session->set_flashdata('flash_message', $msg);
            url_redirect('/');
        }
        
        $this->layouts->set_title('Resetovanje šifre');
        $this->layouts->view('reset_password', $data, 'login_tailwind');
    }

    public function reset_password()
    {
        $this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email',
            array(  'required' => 'Email adresa je obavezna.',
            'valid_email' => 'Email adresa nije pravilno napisana.'));        
        $this->form_validation->set_rules('password', 'Password', 'trim|required',
            array('required' => 'Šifra je obavezna.'));
        $this->form_validation->set_rules('confirm', 'Password Confirmation', 'trim|required|matches[password]',
            array(  'required' => 'Potvrda šifre je obavezna.',
                    'matches' => 'Šifra nije uspešno potrvđena.'));        

        if ($this->form_validation->run()) {
            $data = [
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password'),
                "reset_key" => $this->input->post('code')
            ];

            if ($this->user->reset_password($data) === true) {
                // Set notification
                $msg = $this->alerts->render('teal', 'Promenjena šifra', 'Tvoja šifra je uspešno promenjena. Možeš da se prijaviš sa novom šifrom.');
                $this->session->set_flashdata('flash_message', $msg);
                $response['status'] = "success";
            } else {
                $response['status'] = "user_error";
                $response['errors'] = "Email adresa i kod ne odgovaraju.";
            }
        } else {
            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }
            $response['errors'] = array_filter($errors); // Some might be empty
            $response['status'] = 'form_error';

            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $response);
        }
        header('Content-type: application/json');
        echo json_encode($response);
        exit();
    }

    public function logout()
    {
        delete_cookie('usr-vezba');
        url_redirect('/');
    }

    public function registration_by_invitation_form()
    {
        $data = [
            'email' => $this->input->get('email'),
            'token' => $this->input->get('code')
        ];
        if($this->user->check_invite_token($data) == false || $data['token'] == "") {
            // Notification
            $msg = $this->alerts->render('red', 'Attention', 'E-mail and code do not fit. Try again!');
            $this->session->set_flashdata('flash_message', $msg);
            url_redirect('/');
        }
        $this->layouts->set_title('Registracija po Pozivu');
        $this->layouts->view('registration_by_invitation_tailwind', $data, 'login_tailwind');
    }

    public function register_by_invitation()
    {
        $token = $this->input->post('token');
        $response = $this->user->register(true);
        header('Content-type: application/json');
        echo json_encode($response);
        // var_dump($response['status']);
        if($response['status'] == 'success') {
            $user_id = $response['user_id'];
            $this->user->activate($user_id);
            $this->load->model('Reservation_model', 'res');
            $this->res->new_registered_member($user_id, $token);
        }
        exit();
    }
}