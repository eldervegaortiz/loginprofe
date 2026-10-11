<?php
require_once __DIR__ . '/db/funciones.php';
$errores = login_user();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de barcos - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="/loginprofe1termil/db/scss/build/css/app.css">
</head>
<body class="body-login">

    <main class="contenedor-login">
        <h2>Login</h2>

        <?php if (!empty($errores)): ?>
            <div class="errores">
                <?php foreach ($errores as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST" autocomplete="off">
            <label for="correo">Documento de usuario</label>
            <input type="text" name="correo" id="correo" required>

            <label for="contraseña">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" required>

            <input type="submit" name="ingresar" value="Enviar">
        </form>
    </main>

</body>
</html>