<?php

require_once __DIR__ . "/../models/Matricula.php";
require_once __DIR__ . "../../../pago/controllers/PagoController.php";

class MatriculaController
{
    private $modelo;
    private $pagoController;

    public function __construct()
    {
        $this->modelo = new Matricula();
        $this->pagoController = new PagoController();
    }

    public function inscribir($id_estudiante, $id_curso, $monto_curso)
    {
        // Primero, procesar el pago
        $resultado_pago = $this->pagoController->procesarPago($id_estudiante, $id_curso, $monto_curso);

        if (!$resultado_pago['exito']) {
            return ['exito' => false, 'mensaje' => $resultado_pago['mensaje'] ?? 'Error al procesar el pago'];
        }

        // Si el pago es exitoso, proceder con la inscripción de la matrícula
        return $this->modelo->inscribirEstudiante($id_estudiante, $id_curso);
    }

    public function obtenerCursosInscritos($id_estudiante)
    {
        return $this->modelo->obtenerMatriculasDeEstudiante($id_estudiante);
    }

    public function verificarInscripcion($id_estudiante, $id_curso)
    {
        return $this->modelo->verificarMatricula($id_estudiante, $id_curso);
    }

    public function obtenerInscritosPorCurso($id_curso)
    {
        return $this->modelo->obtenerInscritosPorCurso($id_curso);
    }
}
