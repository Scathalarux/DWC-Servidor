<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class UsuariosSistemaModel extends BaseDbModel
{

    public const ORDER_COLUMNS = ['nombre_completo', 'dni', 'email', 'id_rol'];


    public function getAll(array $data, int $order): array
    {
        $filtros = $this->filtrosQuery($data);

        $sentido = $order > 0 ? ' ASC ' : ' DESC ';
        $order = abs($order);

        if ($filtros['conditions'] !== []) {
            $sql = 'SELECT u.*, ar.nombre_rol FROM usuario_sistema u JOIN aux_rol ar ON u.id_rol = ar.id_rol '
                . " where " . implode(' AND ', $filtros['conditions'])
                . " order by " . self::ORDER_COLUMNS[$order - 1] . $sentido;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = 'SELECT u.*, ar.nombre_rol FROM usuario_sistema u JOIN aux_rol ar ON u.id_rol = ar.id_rol '
                . " order by " . self::ORDER_COLUMNS[$order - 1] . $sentido;
            $stmt = $this->pdo->query($sql);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $conditions = [];
        $vars = [];

        //nombre completo
        if (!empty($data['nombre_completo'])) {
            $conditions[] = ' u.nombre_completo LIKE :nombre_completo ';
            $vars['nombre_completo'] = "%" . $data['nombre_completo'] . "%";
        }

        //id_rol
        if (!empty($data['id_rol'])) {
            $conditions[] = ' u.id_rol = :id_rol ';
            $vars['id_rol'] = $data['id_rol'];
        }

        return ['conditions' => $conditions, 'vars' => $vars];
    }

    public function getByDni(string $dni): false|array
    {
        $sql = 'SELECT * FROM usuario_sistema WHERE dni = :dni';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['dni' => $dni]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function upDate(int $idUsuario): void
    {
        $sql = 'UPDATE usuario_sistema  SET ultimo_acceso = now() WHERE id_usuario = :id_usuario';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $idUsuario]);
    }

    public function getByNombre(string $nombre_completo): array|false
    {
        $sql = 'SELECT * FROM usuario_sistema WHERE nombre_completo = :nombre_completo';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nombre_completo' => $nombre_completo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUsuario(array $data): bool
    {
        $sql = 'INSERT INTO usuario_sistema (id_rol, dni, email, nombre_completo, contrasinal, ultimo_acceso, idioma, baja) 
                VALUES (:id_rol, :dni, :email, :nombre_completo, :contrasinal, null, :idioma, :baja)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function getById(int $idUsuario): false|array
    {
        $sql = 'SELECT * FROM usuario_sistema WHERE id_usuario = :id_usuario';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editUsuario(int $idUsuario, array $data): bool
    {
        $sql = 'UPDATE usuario_sistema SET id_rol =:id_rol, dni= :dni, email=:email, nombre_completo = :nombre_completo, contrasinal = :contrasinal, idioma =:idioma WHERE id_usuario = :id_usuario';
        $stmt = $this->pdo->prepare($sql);
        $data['id_usuario'] = $idUsuario;
        $stmt->execute($data);
        return $stmt->rowCount() === 1;

    }

    public function changeBaja(int $idUsuario, int $baja): bool
    {
        $sql = 'UPDATE usuario_sistema SET baja =:baja WHERE id_usuario = :id_usuario';
        $stmt = $this->pdo->prepare($sql);
        $data['baja'] = $baja;
        $data['id_usuario'] = $idUsuario;
        $stmt->execute($data);
        return $stmt->rowCount() === 1;
    }

    public function getByEmail(string $email): false|array
    {
        $sql = 'SELECT * FROM usuario_sistema WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUsuario(int $idUsuario): bool
    {
        $sql = 'DELETE FROM usuario_sistema WHERE id_usuario = :id_usuario';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_usuario' => $idUsuario]);
    }

    public function getUsuario(int $idUsuario)
    {
    }
}