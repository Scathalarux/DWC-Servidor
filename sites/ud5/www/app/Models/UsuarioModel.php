<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class UsuarioModel extends BaseDbModel
{
    private const BASE_QUERY = "SELECT u.* , ar.nombre_rol, ac.country_name
                                    FROM usuario u 
                                    JOIN aux_rol ar on u.id_rol = ar.id_rol 
                                    LEFT JOIN aux_countries ac on u.id_country = ac.id";
    /*//Ya no lo necesitaríamos al extender el BaseDbModel
     * public function __construct()
    {
        //Creamos las variables
        $host = $_ENV['db.host'];
        $db = $_ENV['db.schema'];
        $user = $_ENV['db.user'];
        $pass = $_ENV['db.pass'];
        $charset = $_ENV['db.charset'];
        $emulated = $_ENV['db.emulated'];

        //Creamos el DSN
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        //Creamos las opciones
        $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => $emulated
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }*/
    public function getAllUsuarios(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuariosSalario(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY . " ORDER BY u.salarioBruto DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuariosStandard(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY . " WHERE ar.nombre_rol LIKE 'standard'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuarioByName(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY . " WHERE u.username LIKE 'Carlos%'");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUsuariosByUsername(string $username): array
    {
        $stmt = $this->pdo->prepare(self::BASE_QUERY . " WHERE u.username LIKE :username");
        $stmt->execute(['username' => "%$username%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuariosByRol(int $rol): array
    {
        $stmt = $this->pdo->prepare(self::BASE_QUERY . " WHERE u.id_rol = :id_rol");
        $stmt->execute(['id_rol' => $rol]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuariosBySalario(int $salario): array
    {
        $stmt = $this->pdo->prepare(self::BASE_QUERY . " WHERE u.salarioBruto = :salarioBruto");
        $stmt->execute(['salarioBruto' => $salario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuariosByCotizacion(int $cotizacion): array
    {
        $stmt = $this->pdo->prepare(self::BASE_QUERY . " WHERE u.retencionIRPF = :retencionIRPF");
        $stmt->execute(['retencionIRPF' => $cotizacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
