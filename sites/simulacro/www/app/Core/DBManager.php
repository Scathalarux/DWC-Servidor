<?php

declare(strict_types=1);

namespace Com\Daw2\Core;

use PDO;

class DBManager
{
    // Contenedor de la instancia de la Clase
    private static ?DBManager $instance = null;
    private ?PDO $db = null;

    //Previene creacion de objetos via new

    private function __construct()
    {
    }

    // Única forma para obtener el objeto singleton

    public static function getInstance(): DBManager
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection($emulatePrepares = false): PDO
    {
        if (is_null($this->db)) {
            $host = $_ENV['DB.HOST'];
            $db = $_ENV['DB.SCHEMA'];
            $user = $_ENV['DB.USER'];
            $pass = $_ENV['DB.PASS'];
            $charset = $_ENV['DB.CHARSET'];
            $emulated = (bool)$_ENV['DB.EMULATED'];

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => $emulated,
            ];
            try {
                $this->db = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return $this->db;
    }
}
