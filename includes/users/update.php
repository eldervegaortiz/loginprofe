<?php
require_once __DIR__ . '/../../db/conexion.php';
/** @var mysqli $conex */

$errores = [];

// Validar ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../../pag/users.php");
    exit;
}

$id = (int)$_GET['id'];

// Obtener los datos del usuario
$query_select = "SELECT * FROM usuario WHERE id = $id";
$resultado_select = mysqli_query($conex, $query_select);

if (!$resultado_select || mysqli_num_rows($resultado_select) === 0) {
    header("Location: ../../pag/users.php");
    exit;
}

$usuario = mysqli_fetch_assoc($resultado_select);

// Procesar actualización al presionar "Guardar cambios"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $cedula   = trim($_POST['cedula'] ?? '');
    $nombre   = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    
    $contraseña_actual = $_POST['contraseña'] ?? '';
    $nueva_contraseña  = $_POST['nueva_contraseña'] ?? '';
    $conf_contraseña   = $_POST['conf_contraseña'] ?? '';

    if (!$cedula)   $errores[] = "El campo Cédula es requerido.";
    if (!$nombre)   $errores[] = "El campo Nombre es requerido.";
    if (!$apellido) $errores[] = "El campo Apellido es requerido.";
    if (!$correo)   $errores[] = "El campo Correo es requerido.";
    if (!$telefono) $errores[] = "El campo Teléfono es requerido.";

    if (!empty($nueva_contraseña)) {
        if (!password_verify($contraseña_actual, $usuario['contraseña']) && $contraseña_actual !== $usuario['contraseña']) {
            $errores[] = "La contraseña actual es incorrecta.";
        }
        if ($nueva_contraseña !== $conf_contraseña) {
            $errores[] = "La nueva contraseña y su confirmación no coinciden.";
        }
    }

    if (empty($errores)) {
        if (!empty($nueva_contraseña)) {
            $pass_hash = password_hash($nueva_contraseña, PASSWORD_BCRYPT);
            $query_update = "UPDATE usuario 
                             SET cedula = '$cedula', 
                                 nombre = '$nombre', 
                                 apellido = '$apellido', 
                                 correo = '$correo', 
                                 telefono = '$telefono', 
                                 contraseña = '$pass_hash' 
                             WHERE id = $id";
        } else {
            $query_update = "UPDATE usuario 
                             SET cedula = '$cedula', 
                                 nombre = '$nombre', 
                                 apellido = '$apellido', 
                                 correo = '$correo', 
                                 telefono = '$telefono' 
                             WHERE id = $id";
        }

        if (mysqli_query($conex, $query_update)) {
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
    <title>Actualización de usuario</title>
</head>
<body>

    <h2>Actualización de usuario</h2>

    <?php if (!empty($errores)): ?>
        <div style="color: red; margin-bottom: 15px;">
            <?php foreach ($errores as $error): ?>
                <p style="margin: 3px 0;"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="update.php?id=<?php echo $id; ?>" method="POST" autocomplete="off">
        
        <label for="cedula">Cedula: </label>
        <input type="text" name="cedula" id="cedula" value="<?php echo htmlspecialchars($_POST['cedula'] ?? $usuario['cedula'] ?? ''); ?>"><br><br>

        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($_POST['nombre'] ?? $usuario['nombre'] ?? ''); ?>"><br><br>

        <label for="apellido">Apellido: </label>
        <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($_POST['apellido'] ?? $usuario['apellido'] ?? ''); ?>"><br><br>

        <label for="correo">Correo: </label>
        <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($_POST['correo'] ?? $usuario['correo'] ?? ''); ?>"><br><br>

        <label for="contraseña">Contraseña: </label>
        <input type="password" name="contraseña" id="contraseña"><br><br>

        <label for="nueva_contraseña">Nueva contraseña: </label>
        <input type="password" name="nueva_contraseña" id="nueva_contraseña"><br><br>

        <label for="conf_contraseña">Confirmar Contraseña: </label>
        <input type="password" name="conf_contraseña" id="conf_contraseña"><br><br>

        <label for="telefono">Telefono: </label>
        <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($_POST['telefono'] ?? $usuario['telefono'] ?? ''); ?>"><br><br>

        <input type="submit" name="editar" value="Guardar cambios"><br><br>

        <a href="../../pag/users.php">Cancelar</a>

    </form>

</body>
</html>