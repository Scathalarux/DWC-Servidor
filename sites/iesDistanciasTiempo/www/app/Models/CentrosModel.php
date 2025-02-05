<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CentrosModel extends BaseDbModel
{
    public const ORDER_COLUMNS = ['centro_educativo', 'concello', 'codigo'];
    private const SELECT_BASE = 'SELECT c.centro_educativo, c.concello, c.codigo';
    private const FROM = 'FROM centros c
                        JOIN rel_centro_ciclo_formativo rcf ON rcf.codigo_centro = c.codigo
                        JOIN ciclos_formativos cf ON cf.codigo = rcf.codigo_ciclo';

    private const SELECT_CICLOS = "select concat('[',cf.codigo,'] ', cf.nombre)
                                    FROM ciclos_formativos cf
                                    JOIN rel_centro_ciclo_formativo rcf ON  cf.codigo = rcf.codigo_ciclo";

    public function getCentros(array $data): array
    {
        $filtros = $this->getFiltrosQuery($data);
        if($filtros['conditions'] !== []){

        }else{
            $sql=self::SELECT_BASE.self::FROM;
            $stmt = $this->pdo->query($sql);
            $centros = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}