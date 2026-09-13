<?php
require_once '../db/funciones.php';
$errores = login_user();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="index.php" method="POST" autocomplete="off">
        <label>Correo:</label>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="contraseña" required><br><br>

        <input type="submit" name="ingresar" value="Ingresar" style="background-color: #dde1e6; color: white;">
    </form>
   
</body>
</html>