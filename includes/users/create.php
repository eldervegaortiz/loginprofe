<?php
require_once __DIR__ . '/../../db/conexion.php';
/** @var mysqli $conex */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $cedula     = trim($_POST['cedula'] ?? '');
    $nombre     = trim($_POST['nombre'] ?? '');
    $apellido   = trim($_POST['apellido'] ?? '');
    $correo     = trim($_POST['correo'] ?? '');
    $contraseña = $_POST['contraseña'] ?? '';
    $telefono   = trim($_POST['telefono'] ?? '');

    if ($cedula && $nombre && $apellido && $correo && $contraseña && $telefono) {
        $pass_hash = password_hash($contraseña, PASSWORD_BCRYPT);

        $query = "INSERT INTO usuario (cedula, nombre, apellido, correo, contraseña, telefono) 
                  VALUES ('$cedula', '$nombre', '$apellido', '$correo', '$pass_hash', '$telefono')";

        if (mysqli_query($conex, $query)) {
            header("Location: ../../pag/users.php");
            exit;
        } else {
            echo "Error al insertar: " . mysqli_error($conex);
        }
    }
}
?>