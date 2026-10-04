<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../index.php");
    exit;
}

require_once __DIR__ . '/../../db/conexion.php';
$id = $_GET['id'] ?? null;

if ($id) {
    $query = "DELETE FROM cliente WHERE id='$id'";
    mysqli_query($conex, $query);
}

header("Location: cliente.php");
exit;