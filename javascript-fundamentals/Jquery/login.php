<?php header('Access-Control-Allow-Origin: *'); ?>
<?php

$username_real = "test";
$password_real = "test";


$username = $_POST['username'];
$password = $_POST['password'];

if($username == $username_real && $password == $password_real)
{
    header("HTTP/1.1 200 OK");
    echo json_encode(
        array(
            "login" => "successfull"
        )
    );
}
else
{
    header('HTTP/1.0 404 Not found');
}

?>