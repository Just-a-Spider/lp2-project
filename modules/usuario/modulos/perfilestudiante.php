<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

<div class="container">
  <form action="" method="POST" class="formulario">
    <h2 class="titulo">Ver perfil del Estudiante</h2>
    <?php
    
    include("conexionbd.php");
    include("controladoralumno.php"); 


    ?>
    
    <div class="padre">
      <div class="nombre">
        <label for="">Ingrese Dni del estudiante</label>
        <input type="text" name="nombre"><br><br>
      </div>

      <div>
        <input class="boton" type="submit" value="Buscar perfil" name="registro"><br>
      </div>
    </div>
  </form>
</div>