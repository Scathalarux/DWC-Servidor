<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PHPUnit\Util\Exception;

class CategoriaModel extends BaseDbModel
{

    public const SELECT_BASE = "SELECT * FROM categoria ORDER BY nombre_categoria";

    public function getAll(array $filtros = []): array
    {
        $condiciones = [];
        $vars = [];
        if (!empty($filtros['nombre_categoria'])) {
            $condiciones[] = " nombre_categoria LIKE :nombre";
            $vars['nombre'] = "%" . $filtros['nombre_categoria'] . "%";
        }

        if ($condiciones === []) {
            $stmt = $this->pdo->query(self::SELECT_BASE);
        } else {
            $sql = self::SELECT_BASE . ' WHERE ' . implode(' AND ', $condiciones);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($vars);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoria(int $idCategoria): bool|array
    {
        $sql = "SELECT * FROM categoria WHERE id_categoria = :idCategoria";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idCategoria' => $idCategoria]);
        return $stmt->fetch();
    }


    public function addCategoria(array $data): bool|array
    {
        $sql = "INSERT INTO categoria (nombre_categoria, id_padre) VALUES (:nombre_categoria, :id_padre)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->fetch();
    }
}