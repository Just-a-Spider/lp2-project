<?php
class Matricula {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function registrar($idEstudiante, $idCurso, $fecha, $codigoPago) {
        $sql = "INSERT INTO matricula (id_estudiante, id_curso, fecha, codigo_pago, estado_pago) 
                VALUES (?, ?, ?, ?, 'pendiente')";
        $sentencia = $this->conexion->prepare($sql);
        return $sentencia->execute([$idEstudiante, $idCurso, $fecha, $codigoPago]);
    }

    public function verPorEstudiante($idEstudiante) {
        $sql = "SELECT * FROM matricula WHERE id_estudiante = ?";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute([$idEstudiante]);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function validarPago($codigoPago) {
        $sql = "UPDATE matricula SET estado_pago = 'pagado' WHERE codigo_pago = ?";
        $sentencia = $this->conexion->prepare($sql);
        return $sentencia->execute([$codigoPago]);
    }
}
