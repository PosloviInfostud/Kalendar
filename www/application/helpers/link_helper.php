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