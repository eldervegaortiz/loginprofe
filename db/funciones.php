<?php

function obtener_usuarios(){
    try{
        require "conexion.php";
        $sql = "SELECT * FROM usuario";
        $query = mysqli_query($conex, $sql);
        return $query;
    }catch(\Throwable $th){
        var_dump($th);
    }
}

function create_user(){
    require 'conexion.php';               
    $errores = [];

    if (isset($_POST['agregar'])){
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $cedula = $_POST['cedula'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        $confcontraseña = $_POST['confcontraseña'] ?? '';

        if (!$cedula) $errores[] = "Ingrese el número de cédula"; 
        if (!$nombre) $errores[] = "Ingrese un nombre"; 
        if (!$apellido) $errores[] = "Ingrese el apellido"; 
        if (!$correo) $errores[] = "Ingrese el correo"; 
        if (!$telefono) $errores[] = "Ingrese el número de teléfono"; 
        if (!$contraseña) $errores[] = "Ingrese la contraseña"; 
        
        if ($contraseña !== $confcontraseña){
            $errores[] = "Las contraseñas no coinciden"; 
        } else {
            $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);
        }

        $query = "SELECT * FROM usuario WHERE cedula = '$cedula'";
        $resultado = mysqli_query($conex, $query);
        
        if($resultado && $resultado->num_rows > 0){
            $errores[] = "El usuario ya existe";
        }
        
        if (empty($errores)){
            $query = "INSERT INTO usuario (cedula, nombre, apellido, correo, contraseña, telefono) VALUES ('$cedula', '$nombre', '$apellido', '$correo', '$contraseña_hash', '$telefono')";
            $insertar = mysqli_query($conex, $query);

            if($insertar){
                header("Location: ../pag/index.php");
                exit;
            }
        }
    }
    return $errores;
}

function login_user(){
    require 'conexion.php';
    $errores = [];

    if (isset($_POST['ingresar'])){
        $correo = $_POST['correo'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';

        if (!$correo) $errores[] = "El correo es obligatorio";
        if (!$contraseña) $errores[] = "La contraseña es obligatoria";

        if (empty($errores)){
            $query = "SELECT * FROM usuario WHERE correo = '$correo'";
            $resultado = mysqli_query($conex, $query);

            if ($resultado && $resultado->num_rows > 0){
                $usuario = mysqli_fetch_assoc($resultado);
                
                // Verificar la contraseña encriptada
                if (password_verify($contraseña, $usuario['contraseña'])){
                    session_start();
                    $_SESSION['usuario'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                    $_SESSION['login'] = true;

                    header("Location: users.php");
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