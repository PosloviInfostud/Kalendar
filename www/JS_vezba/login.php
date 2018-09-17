<?php
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $data = 
        [ "username" => $_POST['username'],
          "password" => $_POST['password']
        ];

        echo json_encode($data);
        die();
    }