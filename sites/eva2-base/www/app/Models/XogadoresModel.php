<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class XogadoresModel extends BaseDbModel
{
    private const SELECT = 'SELECT x.numero_licencia, x.nome, n.nome as nacionalidade, e.nome_equipo, e.nome_club ';
    private const FROM = ' FROM xogador x
                        LEFT JOIN nacionalidade n on n.codigo = x.nacionalidade
                        JOIN equipo e on e.codigo = x.codigo_equipo ';

    private const ORDER_COLUMNS = ['x.numero_licencia', 'x.nome', 'n.nome', 'e.nome_equipo', 'e.nome_club'];

    private const DEFAULT_ORDER = 1;
    private const DEFAULT_SENTIDO = ' ASC ';
    private const DEFAULT_PAGE = 1;

    private const SIZE_PAGE = 25;

    public function getFilteredXogadores(array $data): false|array
    {
        $filtros = $this->filtrosQuery($data);

        //order validado
        if (isset($data['order'])) {
            if (filter_var($data['order'], FILTER_VALIDATE_INT)
                && (int)$data['order'] > 0
                && (int)$data['order'] <= count(self::ORDER_COLUMNS)) {
                $order = (int)$data['order'];
            } else {
                throw new \InvalidArgumentException('El order debe estár entre 1 y ' . count(self::ORDER_COLUMNS) . ', ambos incluidos');
            }
        } else {
            $order = self::DEFAULT_ORDER;
        }

        //paginacion
        if (isset($data['page'])) {
            if (filter_var($data['page'], FILTER_VALIDATE_INT)
                && (int)$data['page'] > 0) {
                $page = (int)$data['page'];
            } else {
                throw new \InvalidArgumentException('La página debe ser mayor o igual a 1');
            }
        } else {
            $page = self::DEFAULT_PAGE;
        }

        //sentido
        if (isset($data['sentido'])) {
            if (strtoupper($data['sentido']) !== 'ASC' || strtoupper($data['sentido']) !== 'DESC') {
                throw new \InvalidArgumentException('El sentido debe ser ASC o DESC');
            } else {
                $sentido = $data['sentido'];
            }
        } else {
            $sentido = self::DEFAULT_SENTIDO;
        }

        //offset
        $offset = ($page - 1) * self::SIZE_PAGE;


        if ($filtros['conditions'] !== []) {
            $sql = self::SELECT . self::FROM
                . " WHERE " . implode(' AND ', $filtros['conditions'])
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido
                . " LIMIT $offset, " . self::SIZE_PAGE;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = self::SELECT . self::FROM . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido
                . " LIMIT $offset, " . self::SIZE_PAGE;
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
        $sql = "SELECT x.*, n.nome, e.nome_equipo, e.nome_club " . self::FROM . " WHERE numero_licencia = :numero_licencia";
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

    public function addXogador(array $insertData): bool
    {
        $sql = "INSERT INTO xogador (numero_licencia, codigo_equipo, numero, nome, posicion, nacionalidade, ficha, estatura, data_nacemento, temporadas)
                VALUES (:numero_licencia, :codigo_equipo, :numero, :nome, :posicion, :nacionalidade, :ficha, :estatura, :data_nacemento, :temporadas)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($insertData);
    }

    public function editXogadorPut(int $numLicencia, array $data): bool
    {
        $slq = "UPDATE xogador SET numero_licencia = :numero_licencia, codigo_equipo= :codigo_equipo, numero = :numero, nome = :nome, posicion = :posicion, nacionalidade = :nacionalidade, ficha =:ficha, estatura = :estatura, data_nacemento = :data_nacemento, temporadas = :temporadas WHERE numero_licencia = :numLicencia";
        $stmt = $this->pdo->prepare($slq);
        $data['numLicencia'] = $numLicencia;
        $stmt->execute($data);
        return $stmt->rowCount() === 1;

    }

    public function editXogadorPatch(int $numLicencia, array $arrayAux)
    {
        $sql = "UPDATE xogador SET ";
        $auxKeys = [];
        foreach ($arrayAux as $key => $value) {
            $auxKeys[] = " $key = :$key ";
        }
        $sql .= implode(', ', $auxKeys);
        $sql .= " WHERE numero_licencia = :numLicencia";
        $stmt = $this->pdo->prepare($sql);
        $arrayAux['numLicencia'] = $numLicencia;
        $stmt->execute($arrayAux);
        return $stmt->rowCount() === 1;
    }
}