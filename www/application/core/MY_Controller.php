<?php
class MY_Controller extends CI_Controller
{
    public $layout;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $token = $this->input->cookie('usr-vezba',true);
        $user_data = $this->user->get_user_by_token($token);

        $this->user_data = [
            'token' => $token,
            'user' => $user_data
        ];

        $this->layout = 'layout/master';
    }
}