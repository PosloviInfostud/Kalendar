<?php

class Users extends CI_Controller
{
    public function index()
    {
        $this->load->view('header');
        $this->load->view('index');
        $this->load->view('footer');
    }

    public function register()
    {
        $this->load->model('User_model', 'user');
        $this->load->library('form_validation');
        $this->load->library('encryption');

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email|is_unique[users.email]|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.',
                'is_unique' => 'This %s already exists.'
            )
        );
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|trim|matches[password]');

        $message = '';

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $message, "R");

        } else {
            $data = [
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password')
            ];
            $this->user->create($data);
            $message = 'success';
            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 1, NULL, "R");
        }
        // Send response to ajax
        echo $message;
    }

    public function activate()
    {
        $this->load->model('User_model', 'user');

        $data = [
            "email" => $this->input->get('email'),
            "activation_key" => $this->input->get('token')
        ];

        $user = $this->user->get_user_by_email($data['email']);
        // Check if email is registered
        if(empty($user)) {
            echo 'Invalid activation link. Please try again.';
        // Check if both values match
        } elseif($data['email'] == $user['email'] && $data['activation_key'] == $user['activation_key']) {
            $this->user->activate_user($user['id']);
            url_redirect('/users');
        // Handle invalid activation link
        } else {
            echo 'Invalid activation link.';
        }
    }

    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("email", "E-Mail", "trim|required|valid_email");
        $this->form_validation->set_rules("password", "Password", "trim|required");

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
            $email = $this->input->post('email');
            $this->load->model('Logs_model', 'logs');
            $this->logs->user_logs($email, 0, $message);

        } else {
            $data = [
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password')
            ];
            $this->load->model('User_model', 'user');
            $message = $this->user->login($data);
        }
        echo $message;

    }

    public function send_forgot_password_mail()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email','E-Mail','trim|required|valid_email');

        if($this->form_validation->run() == FALSE) {
            $message = validation_errors();

        } else {
            $email = $this->input->post('email');

            $this->load->model('User_model','user');

            if(empty($this->user->get_user_by_email($email))){
                $message = "Please, register first!";
            }
            else {
                $this->load->library('encryption');
                $code = bin2hex($this->encryption->create_key(16));
                $expire = date('Y-m-d h:i:s', strtotime('+5 days'));
                $this->user->set_reset_key($email, $code, $expire);

                // Set SMTP Configuration
                $emailConfig = [
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'visnjamarica@gmail.com',
                    'smtp_pass' => '!v1snj4V1SNJ1C1C4!',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                ];
                // Set your email information
                $from = [
                    'email' => 'visnjamarica@gmail.com',
                    'name' => 'Luka Matkovic'
                ];
                
                $to = array($email);
                $subject = 'Reset Password';
                $this->load->helper('link_helper');

                $password_link = reset_password_link($email, $code);
                $email_message = '
                <html>
                    <head>
                        <title>Reset Password</title>
                    </head>
                    <body>
                        <h2>Reset Password</h2>
                        <p>Please click the link below to fill in your new password.</p>
                        <p>
                            <a href="'.$password_link.'">Reset My Password</a>
                        </p>
                    </body>
                </html>';

                // Load CodeIgniter Email library

                $this->load->library('email', $emailConfig);
                // Sometimes you have to set the new line character for better result
                $this->email->set_newline("\r\n");
                // Set email preferences
                $this->email->from($from['email'], $from['name']);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($email_message);
                // Ready to send email and check whether the email was successfully sent
                if (!$this->email->send()) {
                    // Raise error message
                    show_error($this->email->print_debugger());
                    die;
                }
                $message = "E-mail sent successfully!";
            }
        }
        echo $message;
        die();
    }

    public function reset_password_form()
    {
        $data['email'] = $this->input->get('email');
        $data['code'] = $this->input->get('code');

        $this->load->view('header');
        $this->load->view('reset_password', $data);
    }

    public function reset_password()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email','E-Mail','trim|required|valid_email');
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('confirm','Password Confirmation','trim|required|matches[password]');

        if($this->form_validation->run() == FALSE) {
            $message = validation_errors();

        } else {

            $data = [

                "email" => $this->input->post('email'),
                "password" => $this->input->post('password'),
                "reset_key" => $this->input->post('code')
            ];

            $this->load->model('User_model','user');
            
            if ($this->user->reset_password($data) == true) {
                $session_data = [
                    'message' => "Your password has been successfully reseted! You can now login with your new password!"
                ];
                $this->session->set_userdata($session_data);

                $message = "success";

            } else {
                $message = "E-Mail or code may not be correct or 5 days has run out!";
            }         
        }
        echo $message;
    }

    public function logout()
    {
        $this->load->helper('cookie');
        delete_cookie('usr-vezba');
        $this->session->sess_destroy();
        url_redirect('/users');

    }

    public function profile()
    {
        $this->load->view('header');
        $this->load->view('profile');
        $this->load->view('footer');
    }

    public function edit()
    {
        $this->load->model('User_model', 'user');
        $id = $this->input->post('user_id');
        $user = $this->user->get_single_user($id);

        // send view to ajax
        $form = $this->load->view('users/update', ['user' => $user], TRUE);
        echo $form;
        die();

    }

    public function update()
    {
        $this->load->model('User_model', 'user');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email|is_unique[users.email]|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.',
                'is_unique' => 'This %s already exists.'
            )
        );

        $message = '';

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
            $email = $this->input->post('email');
            $this->load->model('User_model','user');
            $this->user->user_logs($email, 0, $message, "R");

        } else {
            $data = [
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "password" => $this->input->post('password')
            ];
            $this->user->create($data);
            $message = 'success';
            $email = $this->input->post('email');
            $this->load->model('User_model','user');
            $this->user->user_logs($email, 1, NULL, "R");
        }
        // Send response to ajax
        echo $message;
    }
}