<?php

    function url_redirect($url) 
    {
        header('Location:'.$url);
    }

    function user_activation_link($email, $token)
    {
        $url = "http://localhost:8090/activate?email=$email&token=$token";
        return $url;
    }