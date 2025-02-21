<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class XogadoresModel extends BaseDbModel
{
    private const SELECT = 'select x.numero_licencia numLicencia, x.nome, n.nome as nacionalidade, e.nome_equipo as equipo, e.nome_club as club ';
    private const FROM = ' from xogador x
                        left join nacionalidade n on x.nacionalidade = n.codigo
                        left join equipo e on x.codigo_equipo = e.codigo';

    public function getFilteredXogadores(array $data): false|array
    {
        $filtros = $this->filtrosQuery($data);
        if ($filtros['conditions'] !== []) {
            $sql = self::SELECT . self::FROM
                . ' WHERE ' . implode(' AND ', $filtros['conditions']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);

        } else {
            $sql = self::SELECT . self::FROM;
            $stmt = $this->pdo->query($sql);
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $conditions = [];
        $vars = [];

        //licencia

        //nome equipo

        //nacionalidade

        //equipo

        //club


        return ['conditions' => $conditions, 'vars' => $vars];
    }
}