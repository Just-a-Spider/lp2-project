<?php
require_once 'modelos/Matricula.php';

class ControladorMatricula {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new Matricula($conexion);
    }

    public function registrarMatricula($datos) {
        $fecha = date('Y-m-d');
        $codigoPago = uniqid('PAGO-');
        return $this->modelo->registrar($datos['id_estudiante'], $datos['id_curso'], $fecha, $codigoPago);
    }

    public function verMatriculas($idEstudiante) {
        return $this->modelo->verPorEstudiante($idEstudiante);
    }

    public function confirmarPago($codigoPago) {
        return $this->modelo->validarPago($codigoPago);
    }
}
