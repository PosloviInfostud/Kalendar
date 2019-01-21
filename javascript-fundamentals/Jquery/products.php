<?php header('Access-Control-Allow-Origin: *'); ?>
<?php

$naziv = strtolower($_POST['product_name']);

if($naziv == 'cipele')
{
    header( "Content-type: application/json" );
    header("HTTP/1.1 200 OK");
    echo json_encode(
        array(
        "product_name" => 'Italian_shoes',
        "price" => 10000,
        "amount_in_stock" => 4
        )
    );
}
else if($naziv == 'patike')
{
    header( "Content-type: application/json" );
    header("HTTP/1.1 200 OK");
    echo json_encode(
        array(
        "product_name" => 'Addidas',
        "price" => 2000,
        "amount_in_stock" => 40
        )
    );
}
else if($naziv == 'cizme')
{
    header( "Content-type: application/json" );
    header("HTTP/1.1 200 OK");
    echo json_encode(
        array(
        "product_name" => 'Alpina',
        "price" => 30000,
        "amount_in_stock" => 15
        )
    );
}
else if($naziv == 'papuce')
{
    header( "Content-type: application/json" );
    header("HTTP/1.1 200 OK");
    echo json_encode(
        array(
        "product_name" => 'Fila',
        "price" => 500,
        "amount_in_stock" => 1000
        )
    );
}
else
{
    header( "Content-type: application/json" );
    header("HTTP/1.0 200 OK");
    echo json_encode(
        array(
            "product" => "not found"
        )
    );
}
?>