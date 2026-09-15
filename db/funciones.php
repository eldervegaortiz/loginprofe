<?php

function obtener_usuarios(){
    try{
        require __DIR__ . "/conexion.php";
        $sql = "SELECT * FROM usuario";
        $query = mysqli_query($conex, $sql);
        return $query;
    }catch(\Throwable $th){
        var_dump($th);
    }
}

function create_user(){
    require __DIR__ . '/conexion.php';               
    $errores = [];

    if (isset($_POST['agregar'])){
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $cedula = trim($_POST['cedula'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $contraseña = $_POST['contraseña'] ?? '';
        $confcontraseña = $_POST['confcontraseña'] ?? '';

        if (!$cedula) $errores[] = "ingrese el numero de cedula"; 
        if (!$nombre) $errores[] = "ingrese un nombre"; 
        if (!$apellido) $errores[] = "ingrese el apellido"; 
        if (!$correo) $errores[] = "ingrese el correo"; 
        if (!$telefono) $errores[] = "ingrese el numero de telefono"; 
        if (!$contraseña) $errores[] = "ingrese la contraseña"; 
        
        if ($contraseña != $confcontraseña){
            $errores[] = "las contraseñas no coinciden"; 
        } else {
            $contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
        }

        $query = "SELECT * FROM usuario WHERE cedula = '$cedula' OR correo = '$correo';";
        $resultado = mysqli_query($conex, $query);
        
        if($resultado && $resultado->num_rows > 0){
            $errores[] = "el usuario ya existe";
        }
        
        if (empty($errores)){
            $query = "INSERT INTO usuario (cedula, nombre, apellido, correo, contraseña, telefono) VALUES ('".
            $cedula. "', '" .$nombre. "', '" .$apellido. "', '" .$correo. "', '" .$contraseña. "', '" .$telefono. "');";
            $insertar = mysqli_query($conex, $query);

            if($insertar){
                // Redirige al index.php de la raíz
                header("Location: ../index.php");
                exit;
            }
        }
    }
    return $errores;
}

function login_user(){
    require __DIR__ . '/conexion.php';
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

                    // Redirige de la raíz a pag/users.php
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