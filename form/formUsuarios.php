<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>

    <h2>Registro de Usuario</h2>

    <form action="../includes/users/create.php" method="POST" autocomplete="off">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" id="cedula" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required><br><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required><br><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required><br><br>

        <input type="submit" name="guardar" value="Guardar"><br><br>

        <a href="../pag/users.php">Cancelar</a>
    </form>

</body>
</html>