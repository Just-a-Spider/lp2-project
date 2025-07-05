<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Matricula
{
    private $conn = null;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function inscribirEstudiante($id_estudiante, $id_curso)
    {
        // Verificar si ya está inscrito
        $sql_check = "SELECT * FROM matricula WHERE id_estudiante = $id_estudiante AND id_curso = $id_curso";
        $resultado_check = $this->conn->buscar($sql_check);
        if (!empty($resultado_check)) {
            return ['exito' => false, 'mensaje' => 'Ya estás inscrito en este curso'];
        }

        // Inscribir al estudiante
        $fecha_matricula = date('Y-m-d');
        $sql_matricula = "INSERT INTO matricula (id_estudiante, id_curso, fecha) VALUES ($id_estudiante, $id_curso, '$fecha_matricula')";
        $resultado_matricula = $this->conn->correr($sql_matricula);

        if (!$resultado_matricula) {
            return ['exito' => false, 'mensaje' => 'Error al registrar la matrícula'];
        }

        return ['exito' => true, 'mensaje' => 'Inscripción exitosa'];
    }

    public function obtenerMatriculasDeEstudiante($id_estudiante)
    {
        $sql = "SELECT c.*, m.fecha as fecha_matricula FROM curso c JOIN matricula m ON c.id_curso = m.id_curso WHERE m.id_estudiante = $id_estudiante";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron matrículas'];
        }
        return ['exito' => true, 'data' => $resultado];
    }

    public function verificarMatricula($id_estudiante, $id_curso)
    {
        $sql = "SELECT * FROM matricula WHERE id_estudiante = $id_estudiante AND id_curso = $id_curso";
        $resultado = $this->conn->buscar($sql);
        return !empty($resultado);
    }
}