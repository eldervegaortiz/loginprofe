<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../index.php");
    exit;
}

require_once __DIR__ . '/../../db/conexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    if (!empty($nombre) && !empty($cedula)) {
        $query = "INSERT INTO cliente (cedula, nombre, apellido, correo, telefono) VALUES ('$cedula', '$nombre', '$apellido', '$correo', '$telefono')";
        if (mysqli_query($conex, $query)) {
            header("Location: cliente.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="../../db/scss/build/css/app.css">
</head>
<body>
    <main class="contenedor">
        <h2>Registrar Nuevo Cliente</h2>
        <form action="create.php" method="POST">
            <label for="cedula">Cédula:</label><br>
            <input type="text" name="cedula" id="cedula" required><br><br>

            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" id="nombre" required><br><br>

            <label for="apellido">Apellido:</label><br>
            <input type="text" name="apellido" id="apellido" required><br><br>

            <label for="correo">Correo:</label><br>
            <input type="email" name="correo" id="correo" required><br><br>

            <label for="telefono">Teléfono:</label><br>
            <input type="text" name="telefono" id="telefono" required><br><br>

            <input type="submit" value="Guardar Cliente">
        </form>
        <br>
        <a href="cliente.php">Volver</a>
    </main>
</body>
</html>