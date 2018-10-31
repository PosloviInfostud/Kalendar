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
        $this->layouts->view('users/profile', array(), 'master_tailwind');
    }

    public function dashboard()
    {
        $this->layouts->set_title('Dashboard');
        $this->layouts->add_header_include('/scripts/fullcalendar/fullcalendar.min.css');
        $this->layouts->add_footer_include('/scripts/fullcalendar/lib/moment.min.js');
        $this->layouts->add_footer_include('/scripts/fullcalendar/fullcalendar.min.js');
        $this->layouts->add_footer_include('/scripts/fullcalendar/locale/sr.js');
        $this->layouts->add_footer_include('/scripts/fullcalendar/gcal.js');
        $this->load->model('Calendar_model','calendar');
        $data['calendar'] = $this->calendar->get_all_meetings_for_user($this->user_data['user']['id']);
        $this->layouts->view('users/dashboard', $data, 'master_tailwind');
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

    public function change_notifications()
    {
        $user_id = $this->input->post('user_id');
        $notify = $this->input->post('value');
        $column = $this->input->post('column');
        $this->user->change_user_notifications($user_id, $notify, $column);
    }
}