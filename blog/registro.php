<?php

if (isset($_POST)) {

  //conecta con la base de datos
  require_once 'includes/conexion.php';
  //inicia sesion
  if (!isset($_SESSION)) {
    session_start();
  }


    //Recoger los valores del formulario de registro a travez de post
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

    //array de errores

    $errores = array();

    //Validar los datos antes de guardarlos en la base de datos

    //validar nombre
    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/" , $nombre)) {
      $nombre_validado = true;
    }else {
      $nombre_validado = false;
      $errores['nombre'] = "El nombre no es válido";
    }

    //validar apellidos
    if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/" , $apellidos)) {
      $apellidos_validado = true;
    }else {
      $apellidos_validado = false;
      $errores['apellidos'] = "Los apellidos no son validos";
    }

    //validar email
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_valido = true;
    }else {
      $email_valido = false;
      $errores['email'] = "El email no es válido";
    }

    //validar contraseña
    if (!empty($password)) {
      $nombre_valido = true;
    }else {
      $nombre_valido = false;
      $errores['password'] = "Ingrese una password";
    }
    $guardar_usuario = false;
    if (count($errores)==0) {
      $guardar_usuario = true;

      //cifrar la contraseña
      $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);

      //insertar usuario en la base de datos
      $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE());";
      $guardar = mysqli_query($db, $sql);

      if ($guardar) {
        $_SESSION['completado'] = "El registro se ha completado con éxitos ";
      }else{
        $_SESSION['errores']['general']= "Error al guardar usuario";
      }

    }else{
      $_SESSION['errores'] = $errores;
    }
}

header('Location: index.php');
