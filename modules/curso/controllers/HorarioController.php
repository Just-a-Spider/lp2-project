<?php
require_once __DIR__ . "/../models/Horario.php";

class HorarioController
{
    private $modelo;

    private function procesarFechas($dias, $hora, $duracion, $fecha_inicio)
    {
        $fechas_horas_dias = [];
        $dias_semana = [
            'Lunes' => 1,
            'Martes' => 2,
            'Miércoles' => 3,
            'Jueves' => 4,
            'Viernes' => 5,
            'Sábado' => 6,
            'Domingo' => 7
        ];

        foreach ($dias as $dia) {
            $dia_num = $dias_semana[$dia];
            $start = new DateTime($fecha_inicio);
            $diff = ($dia_num - (int)$start->format('N') + 7) % 7;
            $first_date = clone $start;
            $first_date->modify("+$diff days");

            for ($semana = 0; $semana < $duracion; $semana++) {
                $fecha = clone $first_date;
                $fecha->modify("+$semana week");
                $fechas_horas_dias[] = [
                    'fecha' => $fecha->format('Y-m-d'),
                    'hora' => $hora,
                    'dia' => $dia
                ];
            }
        }

        return $fechas_horas_dias;
    }

    public function __construct()
    {
        $this->modelo = new Horario();
    }

    // public function crear($id_curso, $dias, $hora, $duracion, $fecha_inicio = null)
    // {
    //     if (!$fecha_inicio) {
    //         $fecha_inicio = date('Y-m-d');
    //     }
    //     $fechas_horas_dias = $this->procesarFechas($dias, $hora, $duracion, $fecha_inicio);

    //     return $this->modelo->crearHorarios($id_curso, $fechas_horas_dias);
    // }

    // public function actualizar($id_curso, $dias, $hora, $duracion, $fecha_inicio = null)
    // {
    //     if (!$fecha_inicio) {
    //         $fecha_inicio = date('Y-m-d');
    //     }
    //     $fechas_horas_dias = $this->procesarFechas($dias, $hora, $duracion, $fecha_inicio);

    //     return $this->modelo->actualizarHorarios($id_curso, $fechas_horas_dias);
    // }

    public function listarPorCurso($id_curso)
    {
        return $this->modelo->listarPorCurso($id_curso);
    }

    public function verificarConflicto($id_aula, $dias, $hora, $id_curso_excluir = null)
    {
    return $this->modelo->verificarConflictoHorario($id_aula, $dias, $hora, $id_curso_excluir);
    }

    public function crear($id_curso, $dias, $hora, $duracion, $fecha_inicio = null)
    {
    if (!$fecha_inicio) {
        $fecha_inicio = date('Y-m-d');
    }
    
    // Obtener el id_aula del curso
    require_once __DIR__ . '/../models/Curso.php';
    $cursoModel = new Curso();
    $curso = $cursoModel->buscarCursoPorId($id_curso);
    
    if (!$curso['exito']) {
        return ['exito' => false, 'mensaje' => 'Curso no encontrado'];
    }
    
    $id_aula = $curso['data']['id_aula'];
    
    // Verificar conflictos
    $conflicto = $this->verificarConflicto($id_aula, $dias, $hora);
    
    if ($conflicto['conflicto']) {
        return [
            'exito' => false, 
            'mensaje' => $conflicto['mensaje'],
            'horarios_conflicto' => $conflicto['horarios_conflicto']
        ];
    }
    
    $fechas_horas_dias = $this->procesarFechas($dias, $hora, $duracion, $fecha_inicio);
    return $this->modelo->crearHorarios($id_curso, $fechas_horas_dias);
    }
    public function actualizar($id_curso, $dias, $hora, $duracion, $fecha_inicio = null)
    {
    if (!$fecha_inicio) {
        $fecha_inicio = date('Y-m-d');
    }
    
    // Obtener el id_aula del curso
    require_once __DIR__ . '/../models/Curso.php';
    $cursoModel = new Curso();
    $curso = $cursoModel->buscarCursoPorId($id_curso);
    
    if (!$curso['exito']) {
        return ['exito' => false, 'mensaje' => 'Curso no encontrado'];
    }
    
    $id_aula = $curso['data']['id_aula'];
    
    // Verificar conflictos (excluyendo el curso actual)
    $conflicto = $this->verificarConflicto($id_aula, $dias, $hora, $id_curso);
    
    if ($conflicto['conflicto']) {
        return [
            'exito' => false, 
            'mensaje' => $conflicto['mensaje'],
            'horarios_conflicto' => $conflicto['horarios_conflicto']
        ];
    }
    
    $fechas_horas_dias = $this->procesarFechas($dias, $hora, $duracion, $fecha_inicio);
    return $this->modelo->actualizarHorarios($id_curso, $fechas_horas_dias);
}
    
    
}
