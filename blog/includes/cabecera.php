<?php require_once 'includes/helpers.php';?>
<?php require_once 'conexion.php' ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css"  href="./assets/css/style.css">
  </head>
  <body>
    <!-- Cabecera-->
    <header id="cabecera">
      <div id="logo">
        <a href="index.php">
          blog basico php
        </a>

      </div>

      <!-- menu-->
      <nav id ="menu">
        <ul>
          <li>
            <a href="index.php">Inicio</a>
          </li>
          <?php $categorias = conseguirCategorias($db);
          if (!empty($categorias)):
           while($categoria = mysqli_fetch_assoc($categorias)):
           ?>
           <li>
             <a href="categoria.php?id=<?=$categoria['id']?>"><?=$categoria['nombre']?></a>
           </li>
          <?php
              endwhile;
            endif;

           ?>

          <li>
            <a href="index.php">Sobre mi</a>
          </li>

          <li>
            <a href="index.php">Contacto</a>
          </li>
        </ul>
      </nav>
    </header>

    <div id="contenedor">
