<?php
    function url_redirect($url) 
    {
        header('Location:'.$url);
    }
    function user_activation_link($email, $key)
    {
        $url = base_url("activate?email=$email&token=$key");
        return $url;
    }
    function reset_password_link($email, $code)
    {
        $url = base_url("reset_password?email=$email&code=$code");
        return $url;    
    }
    function invitation_registration_link($email, $token)
    {
        $url = base_url("/regsiter_by_invite?email=$email&code=$token");
        return $url;  
    }