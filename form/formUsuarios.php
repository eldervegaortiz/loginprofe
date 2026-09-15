<?php
require_once '../db/funciones.php';
$adduser = create_user();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>

    <form action="formUsuarios.php" method="POST" autocomplete="off">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>
        
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required><br>
        
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" id="cedula" required><br>
         
        <label for="correo">Correo:</label>
        <input type="text" name="correo" id="correo" required><br>
         
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required><br>
         
        <label for="contraseña">Contraseña:</label> 
        <input type="password" name="contraseña" id="contraseña" required><br>
        
        <label for="confcontraseña">Conf. Contraseña:</label>
        <input type="password" name="confcontraseña" id="confcontraseña" required><br><br>
        
        <input type="submit" name="agregar" value="agregar" style="background-color: #28a745; color: white;">
    </form>

    <br>

    <?php
    if (!empty($adduser) && is_array($adduser)) {
        foreach ($adduser as $error){
            echo "<p style='color: red;'>" . $error . "</p>";
        }
    }
    ?>

    <br>
    <a href="../index.php">Ir al Login</a>

</body>
</html>