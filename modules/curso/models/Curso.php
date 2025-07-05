<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Curso
{
    private $conn = null;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function listarCursos()
    {
        $sql = "SELECT * FROM curso";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron cursos'];
        }
        return ['exito' => true, 'data' => $resultado];
    }

    public function listarCursosDisponibles()
    {
        $sql = "SELECT * FROM curso WHERE estado = 'activo'";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No hay cursos disponibles'];
        }
        return ['exito' => true, 'data' => $resultado];
    }

    public function buscarCursoPorId($id_curso)
    {
        $sql = "SELECT * FROM curso WHERE id_curso = $id_curso";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'Curso no encontrado'];
        }
        return ['exito' => true, 'data' => $resultado[0]];
    }


    // Métodos de Admin
    public function registrarCurso($nombre_curso, $duracion, $estado, $costo, $id_aula)
    {
        $sql = "INSERT INTO curso(nombre_curso, duracion, estado, costo, id_aula) 
                VALUES('$nombre_curso', '$duracion', '$estado', $costo, $id_aula)";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al registrar el curso'];
        }
        $id_curso = $this->conn->obtenerConexion()->lastInsertId();
        return ['exito' => true, 'mensaje' => 'Curso registrado exitosamente', 'id_curso' => $id_curso];
    }

    public function actualizarCurso($id_curso, $nombre_curso, $duracion, $estado, $costo, $id_aula)
    {
        $sql = "UPDATE curso SET nombre_curso='$nombre_curso', duracion='$duracion', estado='$estado', costo=$costo, id_aula=$id_aula WHERE id_curso=$id_curso";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al actualizar el curso'];
        }
        return ['exito' => true, 'mensaje' => 'Curso actualizado exitosamente'];
    }

    public function eliminarCurso($id_curso)
    {
        $sql = "DELETE FROM curso WHERE id_curso=$id_curso";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al eliminar el curso'];
        }
        return ['exito' => true, 'mensaje' => 'Curso eliminado exitosamente'];
    }

    public function listarAulas()
    {
        $sql = "SELECT * FROM aula";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron aulas'];
        }
        return ['exito' => true, 'data' => $resultado];
    }

    public function actualizarEstadoCurso($id_curso, $estado)
    {
        $sql = "UPDATE curso SET estado='$estado' WHERE id_curso=$id_curso";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al actualizar el estado del curso'];
        }
        return ['exito' => true, 'mensaje' => 'Estado del curso actualizado exitosamente'];
    }
}
