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
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/loginprofe1termil/db/scss/build/css/app.css">  

   
</head>
<body>

    <header class="header header-navegacion">
    <div class="contenedor contenido-header">
        <h1 class="logo-titulo">Proyecto de barcos</h1>
        <nav class="navegacion-principal">
            <a href="users.php" class="enlace-nav activo">Usuarios</a>
            <a href="../includes/clientes/cliente.php" class="enlace-nav">Clientes</a>
            <a href="../includes/barcos/barcos.php" class="enlace-nav">Barcos</a>
            <a href="cerrarSesion.php" class="btn-logout">Cerrar sesión</a>
        </nav>
    </div>
</header>

    <main class="contenedor">
        <div class="encabezado-seccion">
            <h2>Gestión de Usuarios</h2>
            <a href="../form/formUsuarios.php" class="btn-nuevo">+ Nuevo Usuario</a>
        </div>

        <div class="lista-usuarios">
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
                    <div class="fila-usuario">
                        <div class="info-usuario">
                            <span class="campo"><strong>Cédula:</strong> <?php echo htmlspecialchars($usuario['cedula'] ?? $usuario['id'] ?? ''); ?></span>
                            <span class="campo"><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?> <?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?></span>
                            <span class="campo"><strong>Email:</strong> <?php echo htmlspecialchars($usuario['correo'] ?? $usuario['email'] ?? ''); ?></span>
                            <span class="campo"><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?></span>
                        </div>
                        <div class="opciones">
                            <a href="../includes/users/update.php?id=<?php echo $usuario['id'] ?? ''; ?>" class="btn-editar">Actualizar</a> 
                            <a href="../includes/users/delete.php?id=<?php echo $usuario['id'] ?? ''; ?>" class="btn-eliminar">Eliminar</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay usuarios registrados.</p>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>