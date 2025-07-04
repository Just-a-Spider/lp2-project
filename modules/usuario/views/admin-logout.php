<?php
require_once __DIR__ . '../../controllers/AdminController.php';
$controlador = new AdminController();
$controlador->logout();
header('Location: /modules/usuario/views/admin-login.php');
exit();
