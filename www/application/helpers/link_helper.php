<?php
    function url_redirect($url) 
    {
        header('Location:'.$url);
    }
    function user_activation_link($email, $key)
    {
        $url = "http://localhost:8090/activate?email=$email&token=$key";
        return $url;
    }
    function reset_password_link($email, $code)
    {
        $url = "http://localhost:8090/reset_password?email=$email&code=$code";
        return $url;    
    }
    function invitation_registration_link($email, $token)
    {
        $url = "http://localhost:8090/register-by-invite?email=$email&code=$token";
        return $url;  
    }