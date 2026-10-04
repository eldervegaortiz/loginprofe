<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../index.php");
    exit;
}

require_once __DIR__ . '/../../db/conexion.php';


$query = "SELECT * FROM cliente";
$resultado = mysqli_query($conex, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Proyecto de Barcos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../db/scss/build/css/app.css">
</head>
<body>

    <header class="header">
        <div class="contenedor contenido-header">
            <h1>Proyecto de barcos</h1>
            <nav class="navegacion-principal">
                <a href="../../pag/users.php">Usuarios</a>
                <a href="cliente.php">Clientes</a>
                <a href="../barcos/barcos.php">Barcos</a>
                <a href="../../pag/cerrarSesion.php">Cerrar sesión</a>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        <h2>Clientes</h2>

        <a href="create.php">Nuevo Cliente</a>
        <br><br>

        <div class="lista-usuarios">
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($cliente = mysqli_fetch_assoc($resultado)): ?>
                    <div class="fila-usuario">
                        <span class="campo"><strong>Cédula:</strong> <?php echo htmlspecialchars($cliente['cedula'] ?? $cliente['id'] ?? ''); ?></span>
                        <span class="campo"><strong>Nombre:</strong> <?php echo htmlspecialchars($cliente['nombre'] ?? ''); ?></span>
                        <span class="campo"><strong>Apellido:</strong> <?php echo htmlspecialchars($cliente['apellido'] ?? ''); ?></span>
                        <span class="campo"><strong>Email:</strong> <?php echo htmlspecialchars($cliente['correo'] ?? $cliente['email'] ?? ''); ?></span>
                        <span class="campo"><strong>Teléfono:</strong> <?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?></span>
                        <div class="opciones">
                            <a href="update.php?id=<?php echo $cliente['id'] ?? ''; ?>">Actualizar</a> 
                            <a href="delete.php?id=<?php echo $cliente['id'] ?? ''; ?>">Eliminar</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay clientes registrados.</p>
            <?php endif; ?>
        </div>

        <br>
        <a href="../../pag/cerrarSesion.php">Cerrar sesion</a>
    </main>

</body>
</html>