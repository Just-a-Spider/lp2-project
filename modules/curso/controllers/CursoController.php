<?php
require_once __DIR__ . "/../models/Curso.php";

class CursoController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Curso();
    }

    public function listar()
    {
        return $this->modelo->listarCursos();
    }

    public function listarDisponibles()
    {
        $resultado = $this->modelo->listarCursosDisponibles();
        if ($resultado['exito']) {
            return ['exito' => true, 'data' => $resultado['data']];
        } else {
            return ['exito' => false, 'mensaje' => $resultado['mensaje'] ?? 'No hay cursos disponibles'];
        }
    }

    public function buscar($id_curso)
    {
        $resultado = $this->modelo->buscarCursoPorId($id_curso);
        if ($resultado['exito']) {
            return ['exito' => true, 'data' => $resultado['data']];
        } else {
            return ['exito' => false, 'mensaje' => $resultado['mensaje'] ?? 'Curso no encontrado'];
        }
    }

    // Métodos solo para admin
    public function registrarConHorarios($nombre_curso, $duracion, $estado, $costo, $id_aula, $dias, $hora)
    {
        // Primero verificar conflictos de horario antes de crear el curso
        require_once __DIR__ . '/HorarioController.php';
        $horarioCtrl = new HorarioController();

        $conflicto = $horarioCtrl->verificarConflicto($id_aula, $dias, $hora);

        if ($conflicto['conflicto']) {
            return [
                'exito' => false,
                'mensaje' => $conflicto['mensaje'],
                'horarios_conflicto' => $conflicto['horarios_conflicto']
            ];
        }

        // Si no hay conflictos, crear el curso
        $resultado = $this->modelo->registrarCurso($nombre_curso, $duracion, $estado, $costo, $id_aula);

        if ($resultado['exito']) {
            $id_curso = $resultado['id_curso'];

            // Crear los horarios automáticamente
            $horarioResult = $horarioCtrl->crear($id_curso, $dias, $hora, $duracion);

            if ($horarioResult['exito']) {
                return ['exito' => true, 'mensaje' => 'Curso y horarios creados exitosamente', 'id_curso' => $id_curso];
            } else {
                // Si falla crear horarios, eliminar el curso creado
                $this->modelo->eliminarCurso($id_curso);
                return ['exito' => false, 'mensaje' => 'Error al crear los horarios. Curso no creado.'];
            }
        }

        return ['exito' => false, 'mensaje' => $resultado['mensaje'] ?? 'Error al crear el curso'];
    }

    public function actualizar($id_curso, $nombre_curso, $duracion, $estado, $costo, $id_aula)
    {
        $resultado = $this->modelo->actualizarCurso($id_curso, $nombre_curso, $duracion, $estado, $costo, $id_aula);
        if ($resultado['exito']) {
            return ['exito' => true, 'mensaje' => 'Curso actualizado exitosamente'];
        } else {
            return ['exito' => false, 'mensaje' => $resultado['mensaje'] ?? 'Error al actualizar el curso'];
        }
    }

    public function eliminar($id_curso)
    {
        $resultado = $this->modelo->eliminarCurso($id_curso);
        if ($resultado['exito']) {
            return ['exito' => true, 'mensaje' => 'Curso eliminado exitosamente'];
        } else {
            return ['exito' => false, 'mensaje' => $resultado['mensaje'] ?? 'Error al eliminar el curso'];
        }
    }

    public function actualizarEstado($id_curso, $estado)
    {
        $resultado = $this->modelo->actualizarEstadoCurso($id_curso, $estado);
        if ($resultado['exito']) {
            return ['exito' => true, 'mensaje' => 'Estado del curso actualizado exitosamente'];
        } else {
            return ['exito' => false, 'mensaje' => $resultado['mensaje'] ?? 'Error al actualizar el estado del curso'];
        }
    }

    public function listarAulas()
    {
        // Método para obtener las aulas desde un JSON externo
        // $url = "https://raw.githubusercontent.com/Just-a-Spider/lp2_project/main/aulas.json";
        // $json = file_get_contents($url);
        // $aulas = json_decode($json, true);
        // // Fallback si no se pudo obtener el JSON externo. Hasta que se haga el PR a main
        // if (!$aulas) {
        //     $aulas = [
        //         ["id_aula" => 1, "nombre" => "Aula 101", "disponibilidad" => "disponible", "capacidad" => 30],
        //         ["id_aula" => 2, "nombre" => "Aula 102", "disponibilidad" => "ocupado", "capacidad" => 25],
        //         ["id_aula" => 3, "nombre" => "Aula 103", "disponibilidad" => "disponible", "capacidad" => 20],
        //     ];
        // }
        // $aulas_disponibles = array_filter($aulas, function ($aula) {
        //     return $aula['disponibilidad'] === 'disponible';
        // });
        // return array_values($aulas_disponibles);

        // Método alternativo para obtener las aulas desde la base de datos
        $resultado = $this->modelo->listarAulas();
        if ($resultado['exito']) {
            return $resultado['data'];
        } else {
            return ['exito' => false, 'mensaje' => $resultado['mensaje'] ?? 'Error al obtener las aulas'];
        }
    }

    public function obtenerHorariosPorCurso($id_curso)
    {
        require_once __DIR__ . '/HorarioController.php';
        $horario_controller = new HorarioController();
        return $horario_controller->listarPorCurso($id_curso);
    }
}
