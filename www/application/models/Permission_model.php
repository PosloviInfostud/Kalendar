<?php
class Permission_model extends CI_Model
{

    public function is_logged_in()
    {
        $token = $this->input->cookie('usr-vezba');
        $user = $this->user->get_user_by_token($token);

        if(empty($token) || empty($user)) {
            // Notification
            $this->session->set_flashdata('flash_message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                You need to log in to access that page.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            // Delete incorrect cookie
            delete_cookie('usr-vezba');
            url_redirect('/login');
        }
    }

    public function is_admin()
    {
        $token = $this->input->cookie('usr-vezba');
        $user = $this->user->get_user_by_token($token);

        if($user['user_role_id'] != 1) {
            // Notification
            $this->session->set_flashdata('flash_message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            You do not have sufficient permissions to access that page.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            url_redirect('/dashboard');
        }
    }
}