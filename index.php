<?php
require_once __DIR__ . '/db/funciones.php';
$errores = login_user();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>

    <h2>Iniciar Sesión</h2>

    <?php if (!empty($errores)): ?>
        <div style="color: red; margin-bottom: 10px;">
            <?php foreach ($errores as $error) { ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php } ?>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST" autocomplete="off">
        <label for="correo">Correo:</label><br>
        <input type="email" name="correo" id="correo" required><br><br>

        <label for="contraseña">Contraseña:</label><br>
        <input type="password" name="contraseña" id="contraseña" required><br><br>

        <input type="submit" name="ingresar" value="Ingresar">
    </form>

    <br>
    <a href="form/formUsuarios.php">Regístrate aquí por primera vez</a>

</body>
</html>