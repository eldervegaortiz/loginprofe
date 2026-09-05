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

function insertar_usuario($nombre, $apellido){
    try{
        require "conexion.php";
        $sql = "INSERT INTO usuario (nombre, apellido) VALUES ('$nombre', '$apellido');";
        $query = mysqli_query($conex, $sql);
        
        return $query;
    }catch(\Throwable $th){
        var_dump($th);
    }
}

function create_user(){
    require 'conexion.php';               
    $errores = [];
    $nombre = "";
    $apellido = "";
    $cedula = "";
    $correo = "";
    $telefono = "";
    $contraseña = "";
    $confcontraseña = "";

    if (isset($_POST['agregar'])){
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $cedula = $_POST['cedula'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        $confcontraseña = $_POST['confcontraseña'] ?? '';

        if (!$cedula){
            $errores[] = "ingrese el numero de cedula"; 
        }
        if (!$nombre){
            $errores[] = "ingrese un nombre"; 
        }
        if (!$apellido){
            $errores[] = "ingrese el apellido"; 
        }
        if (!$correo){
            $errores[] = "ingrese el correo"; 
        }
        if (!$telefono){
            $errores[] = "ingrese el numero de telefono"; 
        }
        if (!$contraseña){
            $errores[] = "ingrese la contraseña"; 
        }
        if ($contraseña != $confcontraseña){
            $errores[] = "las contraseñas no coinciden"; 
        } else {
            $contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
        }

        $query = "SELECT * FROM usuario WHERE cedula = '" . $cedula . "';";
        $resultado = mysqli_query($conex, $query);
        // echo '<pre>';
        // var_dump($resultado);
        // echo '</pre>';
        // exit;
        if($resultado && $resultado->num_rows > 0){
            $errores[] = "el usuario ya existe";
        }
        
        if (empty($errores)){
            $query = "INSERT INTO usuario (cedula, nombre, apellido, correo, contraseña, telefono) VALUES ('".
            $cedula. "', '" .$nombre. "', '" .$apellido. "', '" .$correo. "', '" .$contraseña. "', '" .$telefono. "');";
            $insertar = mysqli_query($conex, $query);

            if($insertar){
                header("Location: index.php");
                exit;
            }
        } else {
            return $errores;
        }
    }
    return $errores;
}