<?php require_once 'includes/cabecera.php' ?>

    <!-- barra lateral-->
      <?php require_once 'includes/lateral.php' ?>
      <!-- cuerpo -->

      <div id="principal">
        <h1>Todas las entradas</h1>
        <?php
          $entradas = conseguirEntradas($db);
          if(!empty($entradas)):
            while($entrada = mysqli_fetch_assoc($entradas)):
         ?>
         <article class="entrada">
           <a href="entrada.php?id=<?= $entrada['id'] ?>">
             <h2><?= $entrada['titulo']  ?></h2>
             <span class="fecha"><?= $entrada['categoria']." | ".$entrada['fecha']  ?></span>
             <p>
               <?= substr($entrada['descripcion'], 0 ,180)."..."  ?>
             </p>
            </a>
         <?php
            endwhile;
          endif;
          ?>
        </article>

      </div>

    <!-- footer-->
    <?php require_once 'includes/pie.php' ?>
