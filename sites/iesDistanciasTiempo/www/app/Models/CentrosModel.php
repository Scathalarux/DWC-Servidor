<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CentrosModel extends BaseDbModel
{
    public const ORDER_COLUMNS = ['centro_educativo', 'concello', 'codigo'];
    private const SELECT_BASE = 'SELECT c.centro_educativo, c.concello, c.codigo ';
    private const FROM = 'FROM centros c
                            LEFT JOIN rel_centro_ciclo_formativo rcf ON rcf.codigo_centro = c.codigo
                            JOIN ciclos_formativos cf ON cf.codigo = rcf.codigo_ciclo';


    public function getCentros(array $data): array
    {
        //TODO añadir order, sentido y paginación
        $filtros = $this->getFiltrosQuery($data);
        if ($filtros['conditions'] !== []) {

        } else {
            $sql = self::SELECT_BASE . self::FROM;
            $stmt = $this->pdo->query($sql);
            $centros = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if ($centros !== false) {
                foreach ($centros as $centro) {
                    $modeloCiclos = new CiclosModel();
                    $ciclosBorrador = $modeloCiclos->getCiclosByCodigoCentro((int)$centro['codigo']);
                    $ciclos = [];
                    foreach ($ciclosBorrador as $ciclo) {
                        $ciclos[] = $ciclo['nombre_ciclo'];
                    }

                    $centros['ciclos'] = implode(',', $ciclos);
                }
            }else{
                $centros = [];
            }
        }

        return $centros;
    }

    public function getFiltrosQuery(array $data): array
    {
        $conditions = [];
        $vars = [];

        //nombre de centro LIKE
        if (!empty($data['centro'])) {
            $conditions[] = ' c.nombre LIKE :centro ';
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
            $conditions[] = " cf.codigo_ciclo IN (" . implode(',', array_keys($varsCiclos)) . ")";
            $vars = array_merge($vars, $varsCiclos);
        }

        return ['conditions' => $conditions, 'vars' => $vars];
    }
}