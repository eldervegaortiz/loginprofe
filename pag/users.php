<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../db/conexion.php';


$query = "SELECT * FROM usuario";
$resultado = mysqli_query($conex, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Proyecto de Barcos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../db/scss/build/css/app.css">
</head>
<body>

    <header class="header">
        <div class="contenedor contenido-header">
            <h1>Proyecto de barcos</h1>
            <nav class="navegacion-principal">
                <a href="users.php">Usuarios</a>
                <a href="../includes/clientes/cliente.php">Clientes</a>
                <a href="../includes/barcos/barcos.php">Barcos</a>
                <a href="cerrarSesion.php">Cerrar sesión</a>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        <h2>Usuarios</h2>

        <a href="../form/formUsuarios.php">Nuevo Usuario</a>
        <br><br>

        <div class="lista-usuarios">
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
                    <div class="fila-usuario">
                        <span class="campo"><strong>Cédula:</strong> <?php echo htmlspecialchars($usuario['cedula'] ?? $usuario['id'] ?? ''); ?></span>
                        <span class="campo"><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?></span>
                        <span class="campo"><strong>Apellido:</strong> <?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?></span>
                        <span class="campo"><strong>Email:</strong> <?php echo htmlspecialchars($usuario['correo'] ?? $usuario['email'] ?? ''); ?></span>
                        <span class="campo"><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?></span>
                        <div class="opciones">
                            <a href="../includes/users/update.php?id=<?php echo $usuario['id'] ?? ''; ?>">Actualizar</a> 
                            <a href="../includes/users/delete.php?id=<?php echo $usuario['id'] ?? ''; ?>">Eliminar</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay usuarios registrados.</p>
            <?php endif; ?>
        </div>

        <br>
        <a href="cerrarSesion.php">Cerrar sesion</a>
    </main>

</body>
</html>