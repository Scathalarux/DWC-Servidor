<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CentrosModel extends BaseDbModel
{
    public const ORDER_COLUMNS = ['centro_educativo', 'concello', 'codigo'];
    private const SELECT_BASE = "SELECT c.centro_educativo, c.concello, c.codigo ";
    private const FROM = 'FROM centros c
                            LEFT JOIN rel_centro_ciclo_formativo rcf ON rcf.codigo_centro = c.codigo
                            JOIN ciclos_formativos cf ON cf.codigo = rcf.codigo_ciclo';

    private const GROUP_BY = " GROUP BY c.codigo ";


    public function getCentros(array $data): array
    {
        //TODO añadir order, sentido y paginación
        $filtros = $this->getFiltrosQuery($data);
        if ($filtros['conditionsCentros'] !== []) {
            $sql = self::SELECT_BASE
                . self::FROM
                . " WHERE " . implode(' AND ', $filtros['conditionsCentros']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = self::SELECT_BASE
                . self::FROM;
            $stmt = $this->pdo->query($sql);
        }

        $centrosObtenidos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($filtros['conditionsCiclos'] !== []) {
            foreach ($centrosObtenidos as $centro) {
                $ciclosModel = new CiclosModel();
                $ciclos = $ciclosModel->getCiclosByCodigoCentro((int)$centro['codigo'], $filtros);
                $data = [];
                foreach ($ciclos as $ciclo) {
                    $data[] = $ciclo['nombre_ciclo'];
                }
                $centro['ciclos'] = $data;
                $centros[] = $centro;
            }
        } else {

        }

        return $centros;
    }

    public function getFiltrosQuery(array $data): array
    {
        $conditionsCentros = [];
        $conditionsCiclos = [];
        $vars = [];

        //nombre de centro LIKE
        if (!empty($data['centro'])) {
            $conditionsCentros[] = ' c.nombre LIKE :centro ';
            $vars[':centro'] = '%' . $data['centro'] . '%';
        }
        //concello LIKE
        if (!empty($data['concello'])) {
            $conditionsCentros[] = ' c.concello LIKE :concello ';
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
            $conditionsCiclos[] = " cf.codigo_ciclo IN (" . implode(',', array_keys($varsCiclos)) . ")";
            $vars = array_merge($vars, $varsCiclos);
        }

        return ['conditionsCentros' => $conditionsCentros,'conditionsCiclos' => $conditionsCiclos, 'vars' => $vars];
    }
}