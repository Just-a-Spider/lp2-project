<?php

require_once __DIR__ . "../../models/Pago.php";

class PagoController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Pago();
    }

    public function procesarPago($id_estudiante, $id_curso, $monto)
    {
        // Simulación de pago
        $estado_pago = 'exitoso'; // Siempre exitoso para simplificar
        $codigo_transaccion = 'PAY-' . uniqid();

        $resultado = $this->modelo->registrarPago($id_estudiante, $id_curso, $monto, $estado_pago, $codigo_transaccion);
        return $resultado;
    }
}
