<?php
class Reg_log extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Mail_model', 'mail');
        $this->load->model('Logs_model', 'logs');
    }

    public function index()
    {
        $this->layouts->set_title('Reservations');
        $this->layouts->view('index');
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

        // Check if email is registered
        if (empty($user)) {
            echo 'Invalid activation link. Please try again.';
        // Check if both values match
        } elseif ($data['email'] == $user['email'] && $data['activation_key'] == $user['activation_key']) {
            $this->user->activate($user['id']);
            url_redirect('/login');
        // Handle invalid activation link
        } else {
            echo 'Invalid activation link.';
        }
    }

    public function login()
    {
        $this->form_validation->set_rules("email", "E-Mail", "trim|required|valid_email");
        $this->form_validation->set_rules("password", "Password", "trim|required");

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
        $this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email');

        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            if (empty($this->user->get_user_by_email($email))) {
                $response['status'] = 'user_error';
                $response['errors'] = "We can't find the provided email address in our database. Please try again.";
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
                $email_details['subject'] = 'Reset Password';
                $email_details['message'] = $this->load->view('mails/reset_password_mail', ['password_link' => $password_link], true);
                
                // Add email to queue
                $this->mail->add_mail_to_queue(array($email), $email_details);

                // Set status to success
                $response['status'] = 'success';

                // Notification
                $this->session->set_flashdata('flash_message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                E-mail sent successfully! Please, go to your email account and click on the link to enter your new password!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
        if($this->user->check_reset_token($data) == false || $data['code'] == "") {
            $data['error'] = "E-mail and code do not fit. Try again!";
        }
        $this->layouts->set_title('Reset Password');
        $this->layouts->view('reset_password', $data);
    }

    public function reset_password()
    {
        $this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm', 'Password Confirmation', 'trim|required|matches[password]');

        /////////////////////////////////////////////////////////////////////////////////

        if ($this->form_validation->run()) {
            $data = [
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password'),
                "reset_key" => $this->input->post('code')
            ];

            if ($this->user->reset_password($data) == true) {
                // Set notification
                $this->session->set_flashdata('flash_message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Your password has been successfully reseted! You can now login with your new password!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                // Set status
                $response['status'] = "success";
            } else {
                $response['status'] = "user_error";
                $response['errors'] = "E-Mail or code may not be correct or 5 days has run out!";
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
        url_redirect('/login');
    }

    public function registration_by_invitation_form()
    {
        $data = [
            'email' => $this->input->get('email'),
            'token' => $this->input->get('code')
        ];
        if($this->user->check_invite_token($data) == false || $data['token'] == "") {
            $data['error'] = "E-mail and code do not fit. Try again!";
        }
        $this->layouts->set_title('Registration by Invite');
        $this->layouts->view('registration_by_invitation', $data);
    }

    public function register_by_invitation()
    {
        $token = $this->input->post('token');
        $user_id = $this->user->register()['user_id'];
        $this->user->activate($user_id);
        $this->load->model('Reservation_model', 'res');
        $this->res->new_registered_member($user_id, $token);
    }
}