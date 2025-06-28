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
}