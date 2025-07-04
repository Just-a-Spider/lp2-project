<?php
require_once "../models/Cursos.php";

class CursosController
{
    public function mostrar(){
        $cursos = new Cursos();
        return $cursos->mostrar();
    }
    public function eliminar(int $id){
        $cursos = new Cursos();
        $resultado = $cursos->eliminar($id);
        if($resultado){
            header("Location: verCursos.php");
        } else {
            return "Error al eliminar el curso";
        }
    }
    public function buscar(int $id){
        $cursos = new Cursos();
        return $cursos->buscar($id);
    }
    public function editar(array $datos){
        $cursos = new Cursos();
        $resultado = $cursos->editar(
            $datos["nombre_curso"], 
            $datos["duracion"], 
            $datos["estado"], 
            $datos["costo"], 
            $datos["id_aula"], 
            $datos["id"]);
        if($resultado!=0){
            header("Location: verCursos.php");
        } else {
            return "Error al actualizar el curso";
        }
    }
}

