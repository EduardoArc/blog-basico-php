<?php

if (isset($_POST)) {

  //conecta con la base de datos
  require_once 'includes/conexion.php';

    //Recoger los valores del formulario de registro a travez de post
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;


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


    $guardar_usuario = false;
    if (count($errores)==0) {
      $usuario = $_SESSION['usuario'];
      $guardar_usuario = true;

      //comprobar si el usuario existe
      $sql = "SELECT id, email FROM usuarios WHERE email= '$email';";
      $isset_email = mysqli_query($db, $sql);
      $isset_user = mysqli_fetch_assoc($isset_email);

      if($isset_user['id'] == $usuario['id'] || empty($isset_user)){
        //Actualizar usuario en la base de datos
        $id = $_SESSION['usuario']['id'];
        $sql = "UPDATE usuarios SET
                nombre = '$nombre',
                apellidos = '$apellidos',
                email = '$email'
                WHERE id = $id";
        $guardar = mysqli_query($db, $sql);

          if ($guardar) {
            $_SESSION['usuario']['nombre'] = $nombre;
            $_SESSION['usuario']['apellidos'] = $apellidos;
            $_SESSION['usuario']['email'] = $email;

            $_SESSION['completado'] = "Tus datos se ha actualizado con éxitos ";
          }else{
            $_SESSION['errores']['general']= "Fallo al actualizar tus datos";
          }

      }else{
        $_SESSION['errores']['general']= "El usuario ya existe";
      }

    }else{
      $_SESSION['errores'] = $errores;
    }
}

header('Location: mis-datos.php');
