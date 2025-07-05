<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Asistencia
{
    private $conn = null;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function registrarAsistencia($id_estudiante, $id_horario, $estado)
    {
        $sql = "INSERT INTO asistencia (id_estudiante, id_horario, estado) VALUES ($id_estudiante, $id_horario, '$estado')";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al registrar la asistencia'];
        }
        return ['exito' => true, 'mensaje' => 'Asistencia registrada exitosamente'];
    }

    public function obtenerAsistenciasDeEstudiantePorCurso($id_estudiante, $id_curso)
    {
        $sql = "SELECT a.*, h.fecha, h.hora, h.dia FROM asistencia a JOIN horario h ON a.id_horario = h.id_horario WHERE a.id_estudiante = $id_estudiante AND h.id_curso = $id_curso";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron asistencias para este curso'];
        }
        return ['exito' => true, 'data' => $resultado];
    }

    public function obtenerEstudiantesPorCurso($id_curso)
    {
        $sql = "SELECT u.* FROM usuario u JOIN matricula m ON u.id_usuario = m.id_estudiante WHERE m.id_curso = $id_curso";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron estudiantes matriculados en este curso'];
        }
        return ['exito' => true, 'data' => $resultado];
    }

    public function obtenerAsistenciasPorHorario($id_horario)
    {
        $sql = "SELECT id_estudiante, estado FROM asistencia WHERE id_horario = $id_horario";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron asistencias para este horario'];
        }
        return ['exito' => true, 'data' => $resultado];
    }
}
