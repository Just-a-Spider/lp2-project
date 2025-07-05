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
            $db   = 'sistema_matriculas';
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

    /**
     * Ejecuta una consulta SQL y devuelve un array asociativo con los resultados.
     * Si la consulta falla, devuelve un array vacío.
     */
    public function buscar($query)
    {
        if ($this->conn === null) {
            $this->conectar();
        }
        $stmt = $this->conn->query($query);
        $resultado = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        $this->cerrarConexion();
        return $resultado;
    }

    /**
     * Devuelve un booleano indicando si la consulta se ejecutó correctamente.
     */
    public function correr($query)
    {
        if ($this->conn === null) {
            $this->conectar();
        }
        $stmt = $this->conn->exec($query);
        if ($stmt === false) {
            printf('Error al ejecutar la consulta: %s<br>', $this->conn->errorInfo()[2]);
            return false;
        }
        $this->cerrarConexion();
        return true;
    }
}
