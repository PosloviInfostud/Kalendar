<?php
    class User_model extends CI_Model
    {
        public function create($data) {
            $register_token = uniqid(rand(0,9999));

            $sql = 'INSERT INTO users (name, email, password, date_of_birth, activation_token) VALUES (?, ?, ?, ?, ?)';
            $query = $this->db->query($sql, [$data['register_name'],$data['register_email'], $data['register_password'], $data['register_bday'], $register_token]);
        
            $this->send_activation_mail($data['register_email'], $register_token);
        }

        public function send_activation_mail($email, $token) {
                // Set SMTP Configuration
            $emailConfig = [
                'protocol' => 'smtp', 
                'smtp_host' => 'ssl://smtp.googlemail.com', 
                'smtp_port' => 465, 
                'smtp_user' => 'alacanatila@gmail.com', 
                'smtp_pass' => 'Number!00G!', 
                'mailtype' => 'html', 
                'charset' => 'iso-8859-1'
            ];
            // Set your email information
            $from = [
                'email' => 'alacanatila@gmail.com',
                'name' => 'Atila'
            ];
        
            $to = array($email);
            $subject = 'Your activation link';
        //  $message = 'Type your gmail message here'; // use this line to send text email.
            // load view file called "welcome_message" in to a $message variable as a html string.
            $message =  "Click on the link below to activate your account: <b />".user_activation_link($email, $token);
            // Load CodeIgniter Email library
            $this->load->library('email', $emailConfig);
            // Sometimes you have to set the new line character for better result
            $this->email->set_newline("\r\n");
            // Set email preferences
            $this->email->from($from['email'], $from['name']);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            // Ready to send email and check whether the email was successfully sent
            if (!$this->email->send()) {
                // Raise error message
                show_error($this->email->print_debugger());
            } else {
                // Show success notification or other things here
                // echo 'Success to send email';
            }
        }

        public function activate_user($email, $token) {
            $sql = 'UPDATE users SET active = 1 WHERE email = ? AND activation_token = ?';
            $query = $this->db->query($sql, [$email, $token]);
        }

        public function get_user_by_email($email) {
            $results = [];
            $sql = 'SELECT * FROM users WHERE email = ?';
            $query = $this->db->query($sql, [$email]);

            if($query->num_rows()) {
                $results = $query->row_array();
            }
            return $results;
        }

        public function verify_password($password, $hash) {
            $result = password_verify($password, $hash);
            return $result;
        }

        public function set_session($user) {
            $this->load->library('session');
            $session_data = [
                'user_name' => $user['name'],
                'user_email' => $user['email']
            ];

            $this->session->set_userdata($session_data);
        }



    }