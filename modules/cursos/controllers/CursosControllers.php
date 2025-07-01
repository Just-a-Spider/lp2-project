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
}

