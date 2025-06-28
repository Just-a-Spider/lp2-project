<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

<div class="container">
  <form action="" method="POST" class="formulario">
    <h2 class="titulo">REGISTRAR</h2>
    <?php
    
    include("conexionbd.php");
    include("controladoralumno.php"); 


    ?>
    
    <div class="padre">
      <div class="nombre">
        <label for="">Nombres</label>
        <input type="text" name="nombre"><br><br>
      </div>

      <div class="apellido">
        <label for="">Apellidos</label>
        <input type="text" name="apellido"><br><br>
      </div>

      <div class="email">
        <label for="">Usuario</label>
        <input type="text" name="email"><br><br>
      </div>

      <div class="celular">
        <label for="">Celular</label>
        <input type="number" name="celular"><br><br>
      </div>

      <div class="direccion">
        <label for="">Direccion</label>
        <input type="text" name="direccion"><br><br>
      </div>

      <div class="dni">
        <label for="">Dni</label>
        <input type="number" name="dni"><br><br>
      </div>

      <div>
        <input class="boton" type="submit" value="Registrar" name="registro"><br>
      </div>
    </div>
  </form>
</div>