<?php
require './db/funciones.php';

$adduser = create_user();
$dueño = obtener_usuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="index.php" method="POST" autocomplete="off">
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
        <input type="password" name="confcontraseña" id="confcontraseña" required><br>
        
        <input type="submit" name="agregar" value="agregar" style="background-color: #28a745; color: white;">
    </form>

    <br>

    <?php
    if (!empty($adduser) && is_array($adduser)) {
        foreach ($adduser as $error){
            echo "<p>" . $error . "</p>";
        }
    }
    ?>

    <h1>Conexion con mysqli</h1>

    <?php
    if ($dueño) {
        while($user = mysqli_fetch_assoc($dueño)){
            echo "<p><strong>Cédula:</strong> " . $user['cedula'] . " | <strong>Nombre:</strong> " . $user['nombre'] . " " . $user['apellido'] . " | <strong>Correo:</strong> " . $user['correo'] . " | <strong>Teléfono:</strong> " . $user['telefono'] . " | <strong>Contraseña:</strong> " . $user['contraseña'] . "</p>";
        }
    }
    ?>

</body>
</html>