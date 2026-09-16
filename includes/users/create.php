<?php

function obtener_usuarios(){
    try{
        require __DIR__ . "/../../db/conexion.php";
        $sql = "SELECT * FROM usuario";
        $query = mysqli_query($conex, $sql);
        return $query;
    }catch(\Throwable $th){
        var_dump($th);
    }
}

function create_user(){
    require __DIR__ . '/../../db/conexion.php';               
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
                header("Location: ../../index.php");
                exit;
            }
        }
    }
    return $errores;
}
?>