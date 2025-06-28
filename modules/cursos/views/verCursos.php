<?php
require_once '/controllers/CursosController.php';
$curso = new CursosController();
$cursos = $curso->mostrar();
?>
<h1 class="mt-5">Cursos de la Academia E</h1>