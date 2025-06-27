<?php

class Conn
{
    private $conn;

    public function __construct()
    {
        $this->conectar();
        if (!$this->conn) {
            printf('No se pudo establecer la conexión a la base de datos.<br>');
        }
    }

    private function conectar()
    {
        if ($this->conn == null) {
            $host = '127.0.0.1';
            $db   = 'lp2_p3';
            $user = 'root';
            $password = '0116';
            try {
                $this->conn = new PDO(
                    "mysql:host={$host};dbname={$db};charset=utf8;",
                    $user,
                    $password,
                    [
                        PDO::ATTR_PERSISTENT => true
                    ]
                );
            } catch (PDOException $e) {
                printf('Falló la conexión: %s<br>', $e->getMessage());
            }
        }
    }

    public function obtenerConexion()
    {
        if ($this->conn === null) {
            $this->conectar();
        }
        return $this->conn;
    }

    public function cerrarConexion()
    {
        $this->conn = null;
    }

    public function buscar($query)
    {
        if ($this->conn === null) {
            $this->conectar();
        }
        return $this->conn->query($query);
    }
    
    public function correr($query)
    {
        if ($this->conn === null) {
            $this->conectar();
        }
        return $this->conn->exec($query);
    }
}
