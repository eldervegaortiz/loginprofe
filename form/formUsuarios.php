<?php
require_once '../db/funciones.php';
$errores = create_user();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
</head>
<body>
    <h2>Registro de Usuario</h2>

    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="formUsuarios.php" method="POST" autocomplete="off">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>
        
        <label>Apellido:</label>
        <input type="text" name="apellido" required><br>
        
        <label>Cédula:</label>
        <input type="text" name="cedula" required><br>
         
        <label>Correo:</label>
        <input type="email" name="correo" required><br>
        
        <label>Teléfono:</label>
        <input type="text" name="telefono" required><br>
         
        <label>Contraseña:</label> 
        <input type="password" name="contraseña" required><br>
        
        <label>Conf. Contraseña:</label>
        <input type="password" name="confcontraseña" required><br><br>
        
        <input type="submit" name="agregar" value="Registrar" style="background-color: #28a745; color: white;">
    </form>
    <br>
    <a href="../pag/index.php">Ir al Login</a>
</body>
</html>