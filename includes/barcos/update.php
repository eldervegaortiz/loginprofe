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
    header("Location: ../../pag/barcos.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $capacidad = $_POST['capacidad'] ?? 0;

    $queryUpdate = "UPDATE barco SET nombre='$nombre', matricula='$matricula', capacidad='$capacidad' WHERE id='$id'";
    if (mysqli_query($conex, $queryUpdate)) {
        header("Location: ../../pag/barcos.php");
        exit;
    }
}

$querySelect = "SELECT * FROM barco WHERE id='$id'";
$resultado = mysqli_query($conex, $querySelect);
$barco = mysqli_fetch_assoc($resultado);

if (!$barco) {
    header("Location: ../../pag/barcos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Barco</title>
    <link rel="stylesheet" href="../../db/scss/build/css/app.css">
</head>
<body>
    <main class="contenedor">
        <h2>Actualizar Barco</h2>
        <form action="update.php?id=<?php echo $id; ?>" method="POST">
            <label for="nombre">Nombre del Barco:</label><br>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($barco['nombre'] ?? ''); ?>" required><br><br>

            <label for="matricula">Matrícula:</label><br>
            <input type="text" name="matricula" id="matricula" value="<?php echo htmlspecialchars($barco['matricula'] ?? ''); ?>" required><br><br>

            <label for="capacidad">Capacidad:</label><br>
            <input type="number" name="capacidad" id="capacidad" value="<?php echo htmlspecialchars($barco['capacidad'] ?? ''); ?>" required><br><br>

            <input type="submit" value="Actualizar">
        </form>
        <br>
        <a href="../../pag/barcos.php">Volver</a>
    </main>
</body>
</html>