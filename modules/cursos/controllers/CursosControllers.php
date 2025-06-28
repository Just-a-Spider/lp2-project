<?php
require_once "../models/Cursos.php";

class CursosController
{
    public function mostrar(){
        $cursos = new Cursos();
        return $cursos->mostrar();
    }
}