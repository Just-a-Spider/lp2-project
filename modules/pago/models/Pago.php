<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Pago
{
    private $conn = null;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    public function registrarPago($id_estudiante, $id_curso, $monto, $estado, $codigo_transaccion)
    {
        $sql = "INSERT INTO pago (id_estudiante, id_curso, monto, estado, codigo_transaccion) 
                VALUES ($id_estudiante, $id_curso, $monto, '$estado', '$codigo_transaccion')";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al registrar el pago'];
        }
        return ['exito' => true, 'mensaje' => 'Pago registrado exitosamente'];
    }

    public function obtenerPagosPorEstudiante($id_estudiante)
    {
        $sql = "SELECT * FROM pago WHERE id_estudiante = $id_estudiante";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron pagos'];
        }
        return ['exito' => true, 'data' => $resultado];
    }
}
