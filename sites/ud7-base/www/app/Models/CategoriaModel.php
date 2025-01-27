<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CategoriaModel extends BaseDbModel
{
    private const ORDER_STRING = ' ORDER BY nombre_categoria ASC';

    public function find(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categoria WHERE id_categoria = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function get(array $filtros = []): array
    {
        $sql = 'SELECT * FROM categoria';
        $condiciones = [];
        $variables = [];
        if (!empty($filtros['nombre_categoria'])) {
            $condiciones[] = 'nombre_categoria LIKE :nombre_categoria';
            $variables['nombre_categoria'] = "%" . $filtros['nombre_categoria'] . "%";
        }
        if ($condiciones === []) {
            $stmt = $this->pdo->query($sql . self::ORDER_STRING);
        } else {
            $sql .= ' WHERE ' . implode(' AND ', $condiciones) . self::ORDER_STRING;
            $stmt = $this->pdo->prepare($sql);
        }
        $stmt->execute($variables);
        return $stmt->fetchAll();
    }

    public function findByPadreNombre(string $nombre_categoria, ?int $id_padre): array|false
    {
        if(is_null($id_padre)){
            $sql = 'SELECT * FROM categoria WHERE nombre_categoria = :nombre_categoria AND id_padre IS NULL';
            $vars['nombre_categoria'] = $nombre_categoria;
        }else{
            $sql = 'SELECT * FROM categoria WHERE id_padre = :id_padre AND nombre_categoria = :nombre_categoria';
            $vars['id_padre'] = $id_padre;
            $vars['nombre_categoria'] = $nombre_categoria;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($vars);
        return $stmt->fetch();
    }
    public function addCategoria(string $nombre_categoria, ?int $id_padre): bool
    {
        $sql = 'INSERT INTO categoria (nombre_categoria, id_padre) VALUES (:nombre_categoria, :id_padre)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['nombre_categoria' => $nombre_categoria, 'id_padre' => $id_padre]);
    }

    public function deleteCategoria(int $id_categoria): bool
    {
        $sql = 'DELETE FROM categoria WHERE id_categoria = :id_categoria';
        $stmt = $this->pdo->prepare($sql);
        $executed =  $stmt->execute(['id_categoria' => $id_categoria]);
        return ($executed && $stmt->rowCount() === 1);
    }

    public function updateCategoria(array $data):bool
    {
        $sql = "UPDATE categoria SET id_padre = :id_padre, nombre_categoria = :categoria WHERE id_categoria = :id_categoria";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
}
