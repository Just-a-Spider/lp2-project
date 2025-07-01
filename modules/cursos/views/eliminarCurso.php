<?php
require_once "../controllers/CursosControllers.php";
$id = $_GET['id'];
$curs = new CursosController(); 
$curs->eliminar($id);
