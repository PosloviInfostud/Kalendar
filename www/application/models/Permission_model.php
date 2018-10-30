<?php
class Permission_model extends CI_Model
{

    public function is_logged_in()
    {
        $token = $this->input->cookie('usr-vezba');
        $user = $this->user->get_user_by_token($token);

        if(empty($token) || empty($user)) {
            // Notification
            $msg = $this->alerts->render('red', 'Attention', 'You need to log in to access that page.');
            $this->session->set_flashdata('flash_message', $msg);

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

    public function is_member_of_reservation($members, $user_id)
    {
        $members_id = [];
        foreach($members as $mem) {
            $members_id[] = $mem['user_id'];
        }

        if (!in_array($user_id, $members_id)) {
            // Notification
            $this->session->set_flashdata('flash_message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Wrong request!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            url_redirect('/reservations/meetings');
        }
    }

    public function is_editor_of_reservation($id, $user_id)
    {
        $sql = "SELECT res_role_id FROM res_members WHERE res_id = ? AND user_id = ? AND deleted = 0";
        $query = $this->db->query($sql, [$id, $user_id]);

        if ($query->num_rows()) {
            $result = $query->row_array();
        }
        $role = $result['res_role_id'];
        if ($role != 1) {
            // Notification
            $this->session->set_flashdata('flash_message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Wrong request!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            url_redirect('/reservations/meetings');
        }
    }
}