<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../index.php");
    exit;
}

require_once '../db/funciones.php';
$usuarios = obtener_usuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>
<body>

    <h1>Usuarios</h1>

    <a href="../form/formUsuarios.php">Nuevo Usuario</a>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($usuarios) {
                while ($user = $usuarios->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $user['cedula']; ?></td>
                    <td><?php echo $user['nombre']; ?></td>
                    <td><?php echo $user['apellido']; ?></td>
                    <td><?php echo $user['correo']; ?></td>
                    <td><?php echo $user['telefono']; ?></td>
                    <td>
                        <a href="../includes/users/update.php?id=<?php echo $user['id']; ?>">Actualizar</a>
                        <a href="../includes/users/delete.php?id=<?php echo $user['id']; ?>" onclick="return confirm('¿Desea eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="cerrarSesion.php">Cerrar sesion</a>

</body>
</html>includes/users/update.php