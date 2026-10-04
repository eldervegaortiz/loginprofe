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
    $nombre = $_POST['nombre'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $capacidad = $_POST['capacidad'] ?? 0;

    if (!empty($nombre) && !empty($matricula)) {
        $query = "INSERT INTO barco (nombre, matricula, capacidad) VALUES ('$nombre', '$matricula', '$capacidad')";
        if (mysqli_query($conex, $query)) {
            header("Location: barcos.php");
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
    <title>Crear Barco</title>
    <link rel="stylesheet" href="../../db/scss/build/css/app.css">
</head>
<body>
    <main class="contenedor">
        <h2>Registrar Nuevo Barco</h2>
        <form action="create.php" method="POST">
            <label for="nombre">Nombre del Barco:</label><br>
            <input type="text" name="nombre" id="nombre" required><br><br>

            <label for="matricula">Matrícula:</label><br>
            <input type="text" name="matricula" id="matricula" required><br><br>

            <label for="capacidad">Capacidad:</label><br>
            <input type="number" name="capacidad" id="capacidad" required><br><br>

            <input type="submit" value="Guardar Barco">
        </form>
        <br>
        <a href="barcos.php">Volver</a>
    </main>
</body>
</html>