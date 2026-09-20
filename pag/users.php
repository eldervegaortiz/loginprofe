<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../db/conexion.php';
/** @var mysqli $conex */

$query = "SELECT * FROM usuario";
$usuarios = mysqli_query($conex, $query);
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
            <?php if ($usuarios && mysqli_num_rows($usuarios) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($usuarios)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['cedula'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['apellido'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['correo'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono'] ?? ''); ?></td>
                    <td>
                        <a href="../includes/users/update.php?id=<?php echo $row['id']; ?>">Actualizar</a>
                        <a href="../includes/users/delete.php?id=<?php echo $row['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="cerrarSesion.php">Cerrar sesion</a>

</body>
</html>