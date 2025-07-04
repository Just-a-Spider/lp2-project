<?php
require_once '../../../db/Conn.php';

class Cursos
{
    private $id_curso;
    private $nombre_curso;
    private $duracion;
    private $estado;
    private $costo;
    private $id_aula;

    public function mostrar(){
        $conn = new Conn();
        $conexion = $conn->conectar();
        $sql = "SELECT * FROM curso";
        $respuesta = $conexion->query($sql);
        $conn->cerrar();
        return $respuesta;
    }
    public function eliminar($id){
        $conn = new Conn();
        $conexion = $conn->conectar();
        $sql = "DELETE FROM curso WHERE id_curso = $id";
        $respuesta = $conexion->exec($sql);
        $conn->cerrar();
        return $respuesta;
    }
    public function buscar(int $id){
        $conn = new Conn();
        $conexion = $conn->conectar();
        $sql = "SELECT * FROM curso WHERE id_curso = $id";
        $respuesta = $conexion->query($sql);
        $conn->cerrar();
        return $respuesta;
    }
    public function editar($nombre_curso,$duracion,$estado,$costo,$id_aula,$id){
        $conn = new Conn();
        $conexion = $conn->conectar();
        $sql = "UPDATE curso SET nombre_curso='$nombre_curso', duracion='$duracion', estado='$estado', costo='$costo',id_aula='$id_aula' WHERE id_curso = $id";
        $resultado = $conexion->exec($sql);
        $conn->cerrar();
        return $resultado;
    }
}