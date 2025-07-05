<?php

require_once __DIR__ . "/../models/Asistencia.php";
require_once __DIR__ . "/../../curso/controllers/HorarioController.php";

class AsistenciaController
{
    private $modelo;
    private $horarioController;

    public function __construct()
    {
        $this->modelo = new Asistencia();
        $this->horarioController = new HorarioController();
    }

    public function registrar($id_estudiante, $id_horario, $estado)
    {
        return $this->modelo->registrarAsistencia($id_estudiante, $id_horario, $estado);
    }

    public function obtenerAsistenciasDeEstudiantePorCurso($id_estudiante, $id_curso)
    {
        return $this->modelo->obtenerAsistenciasDeEstudiantePorCurso($id_estudiante, $id_curso);
    }

    public function obtenerEstudiantes($id_curso)
    {
        return $this->modelo->obtenerEstudiantesPorCurso($id_curso);
    }

    public function obtenerHorariosPorCurso($id_curso)
    {
        return $this->horarioController->listarPorCurso($id_curso);
    }

    public function obtenerAsistenciasPorHorario($id_horario)
    {
        return $this->modelo->obtenerAsistenciasPorHorario($id_horario);
    }
}
