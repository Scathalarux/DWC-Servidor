<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuariosModel extends BaseDbModel
{
    public const SELECT_BASE = "SELECT u.*, ar.nombre_rol, ac.country_name " . self::FROM;
    public const FROM = "FROM usuario u 
                        JOIN aux_rol ar ON ar.id_rol = u.id_rol
                        JOIN aux_countries ac ON ac.id = u.id_country";


    public const ORDER_COLUMNS = ['username', 'salarioBruto', 'retencionIRPF',  'id_rol', 'id_country'];

    public const DEFAULT_ORDER = 1;

    public function getUsuarios(): array
    {
        $stmt = $this->pdo->query(self::SELECT_BASE);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUsuarioByUsername(string $username): bool|array
    {
        $sql = "SELECT * FROM usuario WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getFilteredUsuarios(array $data, int $order): array
    {
        $filtrosQuery = $this->getFiltros($data);

        $sentido = $order > 0 ? ' ASC ' : ' DESC ';

        $order = abs($order);

        if (!empty($filtrosQuery['condiciones'])) {
            $sql = self::SELECT_BASE . " WHERE " . implode(" AND ", $filtrosQuery['condiciones'])
                . ' ORDER BY ' . self::ORDER_COLUMNS[$order - 1] . $sentido;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtrosQuery['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE . ' ORDER BY ' . self::ORDER_COLUMNS[$order - 1] . $sentido);
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFiltros(array $data): array
    {
        $condiciones = [];
        $vars = [];

        //username
        if (!empty($data['username'])) {
            $condiciones[] = " u.username LIKE :username ";
            $username = $data['username'];
            $vars['username'] = "%$username%";
        }

        //pais
        if (!empty($data['id_country'])) {
            $varsCountry = [];
            $i = 1;
            foreach ($data['id_country'] as $country) {
                $varsCountry[':id_country' . $i] = $country;
                $i++;
            }
            $condiciones[] = " id_country IN (" . implode(", ", array_keys($varsCountry)) . ') ';
            $vars = array_merge($varsCountry, $vars);
        }

        //rol
        if (!empty($data['id_rol'])) {
            $condiciones[] = " ar.id_rol = :id_rol ";
            $vars['id_rol'] = $data['id_rol'];
        }

        //salario bruto
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
            $condiciones[] = " u.retencionIRPF >= :min_retencion ";
            $vars['min_retencion'] = $data['min_retencion'];
        }
        if (!empty($data['max_retencion'])) {
            $condiciones[] = " u.retencionIRPF <= :max_retencion ";
            $vars['max_retencion'] = $data['max_retencion'];
        }

        //activo
        /*if (!empty($data['activo'])) {
            $condiciones[] = " u.activo = 1 ";
        } else {
            $condiciones[] = " u.activo = 0 ";
        }*/

        $resultado['condiciones'] = $condiciones;

        $resultado['vars'] = $vars;

        return $resultado;
    }

    public function addUsuario(array $data): bool
    {
        $sql = 'INSERT INTO usuario (username, salarioBruto, retencionIRPF, activo, id_rol, id_country) VALUES (:username, :salarioBruto, :retencion, :activo; :id_rol, :id_country)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function getMaxPage(array $data, int $pageSize): int
    {
        $filtrosQuery = $this->getFiltros($data);


        if (!empty($filtrosQuery['condiciones'])) {
            $sql = self::SELECT_BASE . " WHERE " . implode(" AND ", $filtrosQuery['condiciones']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtrosQuery['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE);
        }

        $rows = $stmt->fetchColumn(0);
        return (int)ceil($rows / $pageSize);
    }
}
