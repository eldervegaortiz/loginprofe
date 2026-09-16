<?php

function login_user(){
    require __DIR__ . '/conexion.php';
    /** @var mysqli $conex */

    $errores = [];

    if (isset($_POST['ingresar'])){
        $correo = trim($_POST['correo'] ?? '');
        $contraseña = $_POST['contraseña'] ?? '';

        if (!$correo) $errores[] = "Ingrese el correo";
        if (!$contraseña) $errores[] = "Ingrese la contraseña";

        if (empty($errores)){
            $query = "SELECT * FROM usuario WHERE correo = '$correo'";
            $resultado = mysqli_query($conex, $query);

            if ($resultado && mysqli_num_rows($resultado) > 0){
                $usuario = mysqli_fetch_assoc($resultado);
                
                if (password_verify($contraseña, $usuario['contraseña']) || $contraseña === $usuario['contraseña']){
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['usuario'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                    $_SESSION['login'] = true;

                    // Redirige al panel de usuarios
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