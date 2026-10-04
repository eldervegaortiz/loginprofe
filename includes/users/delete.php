<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../../pag/login.php");
    exit;
}

require_once __DIR__ . '/../../db/conexion.php';


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    $query_delete = "DELETE FROM usuario WHERE id = $id";

    if (mysqli_query($conex, $query_delete)) {
        
        header("Location: ../../pag/users.php");
        exit;
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conex);
    }
} else {

    header("Location: ../../pag/users.php");
    exit;
}
?>