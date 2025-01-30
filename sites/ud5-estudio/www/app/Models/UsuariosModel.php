<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuariosModel extends BaseDbModel
{
    private const SELECT_BASE = "SELECT u.*, au.nombre_rol , ac.country_name ".self::FROM;

    private const COUNT_BASE = "SELECT COUNT(*) ".self::FROM;

    private const FROM = "FROM usuario u 
                            JOIN aux_rol au ON au.id_rol = u.id_rol 
                            JOIN aux_countries ac ON ac.id = u.id_country";

    public const ORDER_COLUMNS = ['username', 'salarioBruto', 'retencionIRPF', 'id_rol', 'id_country'];

    public function getUsuarios(array $data, int $order): array
    {
        $filtros = $this->filtrosQuery($data);

        $sentido = $order > 0 ? " ASC " : " DESC ";

        $order = abs($order);

        if (!empty($filtros['condiciones'])) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(' AND ', $filtros['condiciones'])
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);

        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido );
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $condiciones = [];
        $vars = [];

        //username
        if (!empty($data['username'])) {
            $condiciones[] = " u.username LIKE :username ";
            $username = $data['username'];
            $vars['username'] = "%$username%";
        }

        //salariobruto
        if (!empty($data['min_salario'])) {
            $condiciones[] = " u.salarioBruto >= :min_salario ";
            $vars['min_salario'] = $data['min_salario'];
        }
        if (!empty($data['max_salario'])) {
            $condiciones[] = " u.salarioBruto <= :max_salario ";
            $vars['max_salario'] = $data['max_salario'];
        }

        //retencion
        if (!empty($data['min_retencion'])) {
            $condiciones[] = " u.retencion >= :min_retencion ";
            $vars['min_retencion'] = $data['min_retencion'];
        }
        if (!empty($data['max_retencion'])) {
            $condiciones[] = " u.retencionIRPF <= :max_retencion ";
            $vars['max_retencion'] = $data['max_retencion'];
        }

        //rol
        if (!empty($data['id_rol'])) {
            $condiciones[] = 'u.id_rol = :id_rol';
            $vars['id_rol'] = $data['id_rol'];
        }

        //pais
        if (!empty($data['id_country'])) {
            $varsCountry = [];
            $i = 1;
            foreach ($data['id_country'] as $country) {
                $varsCountry[':id_country' . $i] = $country;
                $i++;
            }
            $condiciones[] = 'u.id_country IN (' . implode(',', array_keys($varsCountry)) . ')';
            $vars = array_merge($vars, $varsCountry);
        }


        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;

        return $resultado;
    }


    public function getMaxPage(array $data, int $sizePage): int
    {
        $filtros = $this->filtrosQuery($data);


        if (!empty($filtros['condiciones'])) {
            $sql = self::COUNT_BASE
                . " WHERE " . implode(' AND ', $filtros['condiciones']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);

        } else {
            $stmt = $this->pdo->query(self::COUNT_BASE);
        }
        $rows = $stmt->fetchColumn(0);
        $maxPage = (int)ceil($rows / $sizePage);
        
        return $maxPage;
    }

    public function getUsuariosPage(array $data, int $order, int $sizePage, int $page):array
    {
        $filtros = $this->filtrosQuery($data);

        $sentido = $order > 0 ? " ASC " : " DESC ";

        $order = abs($order);

        $offset = ($page - 1) * $sizePage;

        if (!empty($filtros['condiciones'])) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(' AND ', $filtros['condiciones'])
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido
                . " LIMIT $offset, $sizePage";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);

        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido . " LIMIT $offset, $sizePage");
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findUsuario(string $username):false|array
    {
        $sql='SELECT * FROM usuario WHERE username = :username';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addUsuario(array $data):bool
    {
        $sql = 'INSERT INTO usuario (username, salarioBruto, retencionIRPF, activo, id_rol, id_country) VALUES (:username, :salarioBruto, :retencion, :activo, :id_rol, :id_country)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteUsuario(string $username):bool
    {
        $sql = 'DELETE FROM usuario WHERE username = :username';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':username' => $username]);
    }
}