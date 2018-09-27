<?php
    function url_redirect($url) 
    {
        header('Location:'.$url);
    }
    function user_activation_link($email, $key)
    {
        $url = "http://localhost:8090/users/activate?email=$email&token=$key";
        return $url;
    }
    function reset_password_link($email, $code)
    {
        $url = "http://localhost:8090/users/reset_password_form?email=$email&code=$code";
        return $url;    
    }