<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use PDO;
use PDOException;

class UsuarioModel
{
    public function __construct($_ENV['db.host']->$host)
    {
        /*//Creamos las variables
        $host = "mysql";
        $db = "ud5";
        $user = "admin";
        $pass = "daw2pass";
        $charset = "utf8mb4";*/

        //Creamos el DSN
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        //Creamos las opciones
        $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
