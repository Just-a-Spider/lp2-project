<?php
require_once __DIR__ . '../../controllers/EstudianteController.php';
$controlador = new EstudianteController();
$controlador->logout();
header('Location: /modules/usuario/views/estudiante-login.php');
exit();
