<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../../pag/login.php");
    exit;
}

require_once __DIR__ . '/../../db/conexion.php';
/** @var mysqli $conex */

// Validar que se reciba el ID por GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Consulta para eliminar el usuario por su ID
    $query_delete = "DELETE FROM usuario WHERE id = $id";

    if (mysqli_query($conex, $query_delete)) {
        // Redireccionar de vuelta a la lista de usuarios tras eliminar
        header("Location: ../../pag/users.php");
        exit;
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conex);
    }
} else {
    // Si no viene ID, redirige directamente a la lista
    header("Location: ../../pag/users.php");
    exit;
}
?>