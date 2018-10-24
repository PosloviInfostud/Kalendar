<?php
class Users extends MY_Controller
{
    public function __construct()
    {
            parent::__construct();
            $this->load->model('Permission_model', 'permission');
            $this->load->model('Logs_model','logs');
            $this->permission->is_logged_in();
    }
    
    public function profile()
    {
        $this->layouts->set_title('User Profile');
        $this->layouts->view('users/profile');
    }

    public function dashboard()
    {
        $this->layouts->set_title('Dashboard');
        $this->layouts->add_header_include('js/test.js');
        $this->layouts->add_header_include('css/test.css');
        $this->layouts->add_footer_include('js/test.js');
        $this->layouts->add_footer_include('css/test.css');
        $this->layouts->view('users/dashboard');

    }

    public function edit()
    {
        $id = $this->input->post('user_id');
        $user = $this->user->get_single_user($id);
        $roles = $this->user->get_all_user_roles();

        // send view to ajax
        $form = $this->load->view('users/update', ['user' => $user, 'roles' => $roles], TRUE);
        echo $form;
        die();
    }

    public function update()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email|trim',
            // 'required|valid_email|is_unique[users.email]|trim',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => 'You need to use a valid email address.',
                'is_unique' => 'This %s already exists.'
            )
        );

        $message = '';

        if ($this->form_validation->run() == false) {
            $message = validation_errors();

        } else {
            $data = [
                "id" => $this->input->post('id'),
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "role_id" => $this->input->post('role_id'),
                "active" => $this->input->post('active')
            ];
            
            $this->user->update($data);
            $message = 'success';
        }
        // Send response to ajax
        echo $message;
    }

    public function show_change_notifications_form()
    {
        $user_id = $this->input->post('id');
        $notify = $this->input->post('notify');

        $modal = $this->load->view('users/update_notifications.php', ['user'=> $user_id, 'notify'=>$notify], true);

        echo $modal;
    }

    public function change_notifications()
    {
        $user_id = $this->input->post('user_id');
        $notify = $this->input->post('notify');
        $this->user->change_user_notifications($user_id, $notify);
    }
}