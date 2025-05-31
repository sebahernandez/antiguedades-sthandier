<?php
require_once __DIR__ . '/config.php';

class Database {
    private $host = Config::DB_HOST;
    private $port = Config::DB_PORT;
    private $db_name = Config::DB_NAME;
    private $username = Config::DB_USER;
    private $password = Config::DB_PASS;
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");  // Codificación UTF-8
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}