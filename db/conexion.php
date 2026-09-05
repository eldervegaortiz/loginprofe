<?php
$hostname = "localhost";
$username = "root";
$password = "1234";
$database = "pasabocas";


$conex = mysqli_connect($hostname, $username, $password, $database);

// echo '<pre>';
// var_dump($conex);
// echo '</pre>';

// if ($conex){
//     echo "conexion exitosa";
// }


// if (!$conex){
//     echo "hubo un error";
//     exit;
// }