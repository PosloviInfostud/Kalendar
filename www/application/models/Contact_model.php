<?php
class Contact_model extends CI_Model
{
    public function verify_form_data($data) {

    }

    public function insert($data) {

        $form_values = [];
        foreach($data as $key => $val) {
            $form_values[$val['name']] = $val['value'];
        }
        
        $sql = 'INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)';
        $query = $this->db->query($sql, [$form_values['contact-name'], $form_values['contact-email'], $form_values['contact-message']]);

        $message = "Message sent!";
        echo $message;
        die();
    }
}