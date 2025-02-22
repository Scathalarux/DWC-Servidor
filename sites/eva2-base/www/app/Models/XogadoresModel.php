<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class XogadoresModel extends BaseDbModel
{
    private const SELECT = 'SELECT x.numero_licencia, x.nome, n.nome, e.nome_equipo, e.nome_club ';
    private const FROM = ' FROM xogador x
                        LEFT JOIN nacionalidade n on n.codigo = x.nacionalidade
                        JOIN equipo e on e.codigo = x.codigo_equipo ';

    public function getFilteredXogadores(array $data): false|array
    {
        $filtros = $this->filtrosQuery($data);
        if ($filtros['conditions'] !== []) {
            $sql = self::SELECT . self::FROM
                . " WHERE " . implode(' AND ', $filtros['conditions']);
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
        if (!empty($data['numero_licencia'])) {
            $conditions[] = ' numero_licencia = :numero_licencia';
            $vars['numero_licencia'] = $data['numero_licencia'];
        }

        //nome
        if (!empty($data['nome'])) {
            $conditions[] = ' x.nome = :nome';
            $vars['nome'] = $data['nome'];
        }

        //nacionalidade
        if (!empty($data['nacionalidade'])) {
            $conditions[] = ' n.nome = :nacionalidade';
            $vars['nacionalidade'] = $data['nacionalidade'];
        }

        //equipo
        if (!empty($data['nome_equipo'])) {
            $conditions[] = ' nome_equipo = :nome_equipo';
            $vars['nome_equipo'] = $data['nome_equipo'];
        }

        //club
        if (!empty($data['nome_club'])) {
            $conditions[] = ' nome_club = :nome_club';
            $vars['nome_club'] = $data['nome_club'];
        }


        return ['conditions' => $conditions, 'vars' => $vars];
    }

    public function getXogador(int $numLicencia): false|array
    {
        $sql = self::SELECT . self::FROM . " WHERE numero_licencia = :numero_licencia";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numero_licencia' => $numLicencia]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteXogador(int $numLicencia): bool
    {
        $sql = "DELETE FROM xogador WHERE numero_licencia = :numero_licencia";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['numero_licencia' => $numLicencia]);
    }
}