<?php

//Iniciar la sesión y la conexión con la bd
require_once 'includes/conexion.php';
//recoger datos del formulario
if (isset($_POST)) {

  //borrar sesión del error anterior
  if (isset($_SESSION['error_login'])) {
    unset($_SESSION['error_login']);
  }

  $email = trim($_POST['email']);
  $password = $_POST['password'];

  //consulta para comprobar las credenciales del usuario
  $sql = "SELECT * from usuarios WHERE email = '$email'";
  $login = mysqli_query($db, $sql);

  if ($login && mysqli_num_rows($login ) == 1) {
      $usuario = mysqli_fetch_assoc($login);


      //comprobar la contraseña
      $verify = password_verify($password, $usuario['password']);

      if ($verify) {
        // Utilizar una sesión para guardar los datos del usuario logeado
        $_SESSION['usuario'] = $usuario;


      }else {
        //Si algo falla enviat una sesión con el fallo
        $_SESSION['error_login'] = "Login incorrecto";
      }

  }else {
    //Mensaje de errors
    $_SESSION['error_login'] = "Login incorrecto";
  }

}

//redirigir al index.php
header('Location: index.php');
