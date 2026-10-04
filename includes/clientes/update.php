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

if (!$id) {
    header("Location: cliente.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    $queryUpdate = "UPDATE cliente SET cedula='$cedula', nombre='$nombre', apellido='$apellido', correo='$correo', telefono='$telefono' WHERE id='$id'";
    if (mysqli_query($conex, $queryUpdate)) {
        header("Location: cliente.php");
        exit;
    }
}

$querySelect = "SELECT * FROM cliente WHERE id='$id'";
$resultado = mysqli_query($conex, $querySelect);
$cliente = mysqli_fetch_assoc($resultado);

if (!$cliente) {
    header("Location: cliente.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
    <link rel="stylesheet" href="../../db/scss/build/css/app.css">
</head>
<body>
    <main class="contenedor">
        <h2>Actualizar Cliente</h2>
        <form action="" method="POST">
            <label for="cedula">Cédula:</label><br>
            <input type="text" name="cedula" id="cedula" value="<?php echo $cliente['cedula'] ?? ''; ?>" required><br><br>

            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" id="nombre" value="<?php echo $cliente['nombre'] ?? ''; ?>" required><br><br>

            <label for="apellido">Apellido:</label><br>
            <input type="text" name="apellido" id="apellido" value="<?php echo $cliente['apellido'] ?? ''; ?>" required><br><br>

            <label for="correo">Correo:</label><br>
            <input type="email" name="correo" id="correo" value="<?php echo $cliente['correo'] ?? ''; ?>" required><br><br>

            <label for="telefono">Teléfono:</label><br>
            <input type="text" name="telefono" id="telefono" value="<?php echo $cliente['telefono'] ?? ''; ?>" required><br><br>

            <input type="submit" value="Actualizar">
        </form>
        <br>
        <a href="cliente.php">Volver</a>
    </main>

</body>
</html>