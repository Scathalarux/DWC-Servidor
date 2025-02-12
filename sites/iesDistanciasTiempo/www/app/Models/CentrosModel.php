<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CentrosModel extends BaseDbModel
{
    public const ORDER_COLUMNS = ['c.centro_educativo', 'c.concello', 'c.codigo'];

    private const SELECT_BASE = "SELECT c.* ";
    private const FROM = 'FROM centros c
                            LEFT JOIN rel_centro_ciclo_formativo rcf ON rcf.codigo_centro = c.codigo
                            LEFT JOIN ciclos_formativos cf ON cf.codigo = rcf.codigo_ciclo';


    public function getCentros(array $data, int $order, int $page, int $sizePage): array
    {
        //TODO añadir order, sentido y paginación
        $filtros = $this->getFiltrosQuery($data);

        //SENTIDO
        $sentido = $order > 0 ? ' ASC ' : ' DESC ';

        //obtemos o valor real de order
        $order = abs((int)$order);


        //offset
        $offset = ($page - 1) * $sizePage;

        if ($filtros['conditions'] !== []) {
            $sql = self::SELECT_BASE
                . self::FROM
                . " WHERE " . implode(' AND ', $filtros['conditions'])
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido
                . " LIMIT " . $offset . ', ' . $sizePage;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = self::SELECT_BASE
                . self::FROM
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido
                . " LIMIT " . $offset . ', ' . $sizePage;
            $stmt = $this->pdo->query($sql);
        }

        $centrosObtenidos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($centrosObtenidos as $centro) {
            $ciclosModel = new CiclosModel();
            $ciclos = $ciclosModel->getCiclosByCodigoCentro((int)$centro['codigo']);
            $data = [];
            foreach ($ciclos as $ciclo) {
                $data[] = $ciclo['nombre_ciclo'];
            }
            $centro['ciclos'] = $data;
            $centros[] = $centro;
        }

        return $centros ?? [];
    }

    public function getFiltrosQuery(array $data): array
    {
        $conditions = [];

        $vars = [];

        //nombre de centro LIKE
        if (!empty($data['centro'])) {
            $conditions[] = ' c.centro_educativo LIKE :centro ';
            $vars[':centro'] = '%' . $data['centro'] . '%';
        }
        //concello LIKE
        if (!empty($data['concello'])) {
            $conditions[] = ' c.concello LIKE :concello ';
            $vars[':concello'] = '%' . $data['concello'] . '%';
        }

        //ciclos que se imparten (select multiple)
        if (!empty($data['ciclos'])) {
            $varsCiclos = [];
            $i = 1;
            foreach ($data['ciclos'] as $ciclo) {
                $varsCiclos[":ciclo$i"] = $ciclo;
                $i++;
            }
            $conditions[] = " cf.codigo IN (" . implode(',', array_keys($varsCiclos)) . ")";
            $vars = array_merge($vars, $varsCiclos);
        }

        return ['conditions' => $conditions, 'vars' => $vars];
    }

    public function getMaxPage(array $data, int $sizePage): int
    {
        $filtros = $this->getFiltrosQuery($data);
        if ($filtros['conditions'] !== []) {
            $sql = self::SELECT_BASE
                . self::FROM
                . " WHERE " . implode(' AND ', $filtros['conditions']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = self::SELECT_BASE
                . self::FROM;
            $stmt = $this->pdo->query($sql);
        }
        $rows = $stmt->rowCount();

        return (int)ceil($rows / $sizePage);
    }

    public function getCentroByCodigo(int $codigoCentro): array|false
    {
        $sql = self::SELECT_BASE . self::FROM . " WHERE c.codigo = :codigo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':codigo' => $codigoCentro]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function delete(int $codigoCentro): bool
    {
        $sql = self::SELECT_BASE . self::FROM . " WHERE c.codigo = :codigo";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':codigo' => $codigoCentro]);
    }
}