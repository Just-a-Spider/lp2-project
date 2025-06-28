<?php
require_once 'configuracion/bd.php'; // conexión
require_once 'controladores/ControladorMatricula.php';

$controlador = new ControladorMatricula($conexion);
$registrado = $controlador->registrarMatricula($_POST);

if ($registrado) {
    echo "✅ Matrícula registrada correctamente.";
} else {
    echo "❌ Error al registrar matrícula.";
}
?>
