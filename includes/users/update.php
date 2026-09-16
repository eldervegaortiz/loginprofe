<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../db/conexion.php';
/** @var mysqli $conex */

$id = $_GET['id'] ?? '';
$errores = [];

if (empty($id)) {
    header("Location: ../../pag/users.php");
    exit;
}

// Consultar datos del usuario seleccionado
$query_user = "SELECT * FROM usuario WHERE id = '$id'";
$resultado_user = mysqli_query($conex, $query_user);

if (!$resultado_user || mysqli_num_rows($resultado_user) == 0) {
    header("Location: ../../pag/users.php");
    exit;
}

$usuario = mysqli_fetch_assoc($resultado_user);

// Procesar actualización
if (isset($_POST['actualizar'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $cedula = trim($_POST['cedula'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $contraseña = $_POST['contraseña'] ?? '';
    $confcontraseña = $_POST['confcontraseña'] ?? '';

    if (!$cedula) $errores[] = "Ingrese la cédula";
    if (!$nombre) $errores[] = "Ingrese el nombre";
    if (!$apellido) $errores[] = "Ingrese el apellido";
    if (!$correo) $errores[] = "Ingrese el correo";
    if (!$telefono) $errores[] = "Ingrese el teléfono";

    // Validar contraseña solo si la ingresó
    $contraseña_hash = null;
    if (!empty($contraseña)) {
        if ($contraseña !== $confcontraseña) {
            $errores[] = "Las contraseñas no coinciden";
        } else {
            $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);
        }
    }

    if (empty($errores)) {
        // Actualizar con o sin contraseña
        if ($contraseña_hash !== null) {
            $update_query = "UPDATE usuario SET 
                cedula = '$cedula', 
                nombre = '$nombre', 
                apellido = '$apellido', 
                correo = '$correo', 
                telefono = '$telefono',
                contraseña = '$contraseña_hash'
                WHERE id = '$id'";
        } else {
            $update_query = "UPDATE usuario SET 
                cedula = '$cedula', 
                nombre = '$nombre', 
                apellido = '$apellido', 
                correo = '$correo', 
                telefono = '$telefono' 
                WHERE id = '$id'";
        }

        $actualizar = mysqli_query($conex, $update_query);

        if ($actualizar) {
            header("Location: ../../pag/users.php");
            exit;
        } else {
            $errores[] = "Error al actualizar: " . mysqli_error($conex);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
</head>
<body>

    <h2>Actualizar Usuario</h2>

    <?php if (!empty($errores)): ?>
        <div style="color: red; margin-bottom: 10px;">
            <?php foreach ($errores as $error) { ?>
                <p><?php echo $error; ?></p>
            <?php } ?>
        </div>
    <?php endif; ?>

    <form action="update.php?id=<?php echo $id; ?>" method="POST" autocomplete="off">
        <label for="cedula">Cédula:</label><br>
        <input type="text" name="cedula" id="cedula" value="<?php echo htmlspecialchars($usuario['cedula']); ?>" required><br><br>

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required><br><br>

        <label for="correo">Correo:</label><br>
        <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required><br><br>

        <label for="telefono">Teléfono:</label><br>
        <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required><br><br>

        <label for="contraseña">Nueva Contraseña (opcional):</label><br>
        <input type="password" name="contraseña" id="contraseña"><br><br>

        <label for="confcontraseña">Confirmar Nueva Contraseña:</label><br>
        <input type="password" name="confcontraseña" id="confcontraseña"><br><br>

        <input type="submit" name="actualizar" value="Guardar Cambios">
        <a href="../../pag/users.php">Cancelar</a>
    </form>

</body>
</html>