<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Horario
{
    private $conn = null;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function crearHorarios($id_curso, $fechas_horas_dias)
    {
        foreach ($fechas_horas_dias as $item) {
            $fecha = $item['fecha'];
            $hora = $item['hora'];
            $dia = $item['dia'];
            $sql = "INSERT INTO horario (id_curso, fecha, hora, dia) VALUES ($id_curso, '$fecha', '$hora', '$dia')";
            $resultado = $this->conn->correr($sql);
            if (!$resultado) {
                return ['exito' => false, 'mensaje' => 'Error al crear horarios'];
            }
        }
        return ['exito' => true, 'mensaje' => 'Horarios creados exitosamente'];
    }

    public function actualizarHorarios($id_curso, $fechas_horas_dias)
    {
        // Borra los horarios actuales del curso
        $sql = "DELETE FROM horario WHERE id_curso = $id_curso";
        $this->conn->correr($sql);
        // Crea los nuevos horarios
        $horarios_creados = $this->crearHorarios($id_curso, $fechas_horas_dias);
        return $horarios_creados;
    }

    public function listarPorCurso($id_curso)
    {
        $sql = "SELECT * FROM horario WHERE id_curso = $id_curso";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron horarios para este curso'];
        }
        return ['exito' => true, 'data' => $resultado];
    }
    public function verificarConflictoHorario($id_aula, $dias, $hora_inicio, $id_curso_excluir = null)
    {
    // Calcular hora de fin (1h 30min después)
    $hora_fin = date('H:i:s', strtotime($hora_inicio . ' +1 hour 30 minutes'));
    
    // Construir la condición para los días
    $dias_sql = "'" . implode("','", $dias) . "'";
    
    // SQL para buscar conflictos
    $sql = "SELECT h.*, c.nombre_curso 
            FROM horario h 
            INNER JOIN curso c ON h.id_curso = c.id_curso 
            WHERE c.id_aula = $id_aula 
            AND h.dia IN ($dias_sql)
            AND (
                (h.hora <= '$hora_inicio' AND ADDTIME(h.hora, '01:30:00') > '$hora_inicio') OR
                (h.hora < '$hora_fin' AND ADDTIME(h.hora, '01:30:00') >= '$hora_fin') OR
                ('$hora_inicio' <= h.hora AND '$hora_fin' > h.hora)
            )";
    
    // Excluir el curso actual si estamos editando
    if ($id_curso_excluir) {
        $sql .= " AND h.id_curso != $id_curso_excluir";
    }
    
    $resultado = $this->conn->buscar($sql);
    
    if (!empty($resultado)) {
        return [
            'conflicto' => true,
            'horarios_conflicto' => $resultado,
            'mensaje' => 'Conflicto de horario detectado en el aula'
        ];
    }
    
    return ['conflicto' => false, 'mensaje' => 'No hay conflictos de horario'];
    }
}
