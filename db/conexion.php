<?php
$hostname = "localhost";
$username = "root";
$password = "1234";
$database = "pasabocas";

$conex = mysqli_connect($hostname, $username, $password, $database);

if (!$conex) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>