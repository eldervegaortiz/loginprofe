<?php

function login_user() {
    require_once __DIR__ . '/conexion.php';

    $errores = [];

    if (isset($_POST['ingresar'])) {
        $correo = trim($_POST['correo'] ?? '');
        $contraseña = $_POST['contraseña'] ?? '';

        if (!$correo) {
            $errores[] = "Ingrese el correo";
        }
        if (!$contraseña) {
            $errores[] = "Ingrese la contraseña";
        }

        if (empty($errores)) {
            $stmt = mysqli_prepare($conex, "SELECT * FROM usuario WHERE correo = ?");
            mysqli_stmt_bind_param($stmt, "s", $correo);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $usuario = mysqli_fetch_assoc($resultado);
                if (password_verify($contraseña, $usuario['contraseña']) || $contraseña === $usuario['contraseña']) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['usuario'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                    $_SESSION['login'] = true;
                    header("Location: pag/users.php");
                    exit;
                } else {
                    $errores[] = "Contraseña incorrecta";
                }
            } else {
                $errores[] = "El usuario no existe";
            }
        }
    }
    return $errores;
}
?>