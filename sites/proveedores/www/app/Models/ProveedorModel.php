<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{
    public const SELECT_BASE = "SELECT pv.*,  ac.nombre_continente, ac.continente_avisar, atp.nombre_tipo_proveedor" . self::FROM;
    public const COUNT_BASE = "SELECT COUNT(*)" . self::FROM;

    public const FROM = " FROM proveedor pv
                       JOIN aux_continente ac ON ac.id_continente = pv.id_continente
                       LEFT JOIN aux_tipo_proveedor atp ON atp.id_tipo_proveedor = pv.id_tipo_proveedor";

    public const COLUMNS_ORDER = ['alias', 'nombre_completo', 'id_tipo_proveedor', 'id_continente', 'anho_fundacion'];

    public function getFilteredProveedores(array $data, int $order): array
    {
        //procesamos la existencia de filtros
        $filtros = $this->filtrosQuery($data);

        //obtenemos el sentido a partir del signo del order
        $sentido = $order > 0 ? ' ASC ' : ' DESC ';

        //nos quedamos con en valor absoluto del order para indicar la columna por la que ordenar
        $order = abs($order);

        if (!empty($filtros['condiciones'])) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(' AND ', $filtros['condiciones'])
                . " ORDER BY " . self::COLUMNS_ORDER[$order - 1] . $sentido;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE . " ORDER BY " . self::COLUMNS_ORDER[$order - 1] . $sentido);
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $condiciones = [];
        $vars = [];

        //alias
        if (!empty($data['alias'])) {
            $condiciones[] = " pv.alias LIKE :alias ";
            $alias = $data['alias'];
            $vars['alias'] = "%$alias%";
        }

        //nombre completo
        if (!empty($data['nombre_completo'])) {
            $condiciones[] = " pv.nombre_completo LIKE :nombre_completo ";
            $nombreCompleto = $data['nombre_completo'];
            $vars['nombre_completo'] = "%$nombreCompleto%";
        }

        //tipo
        if (!empty($data['id_tipo'])) {
            $variablesTipo = [];
            $i = 1;

            foreach ((array)$data['id_tipo'] as $tipo) {
                $variablesTipo[':id_tipo_proveedor' . $i] = $tipo;
                $i++;
            }
            $condiciones[] = " pv.id_tipo_proveedor IN (" . implode(',', array_keys($variablesTipo)) . ") ";
            $vars = array_merge($vars, $variablesTipo);
        }

        //contiente
        if (!empty($data['id_continente'])) {
            $condiciones[] = " pv.id_continente = :id_continente ";
            $vars['id_continente'] = $data['id_continente'];
        }

        //año fundación
        if (!empty($data['min_anho'])) {
            $condiciones[] = " pv.anho_fundacion >= :min_anho ";
            $vars['min_anho'] = $data['min_anho'];
        }
        if (!empty($data['max_anho'])) {
            $condiciones[] = " pv.anho_fundacion <= :max_anho ";
            $vars['max_anho'] = $data['max_anho'];
        }


        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;
        return $resultado;
    }

    public function getMaxPages(array $data, int $sizePage): int
    {
        $filtros = $this->filtrosQuery($data);

        if (!empty($filtros['condiciones'])) {
            $sql = self::COUNT_BASE . " WHERE " . implode(' AND ', $filtros['condiciones']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::COUNT_BASE);
        }

        $rows = $stmt->fetchColumn(0);
        $maxPages = (int)ceil($rows / $sizePage);

        return $maxPages;
    }

    public function getFilteredPageProveedores(array $data, int $order, int $sizePage, int $page): array
    {
        //procesamos la existencia de filtros
        $filtros = $this->filtrosQuery($data);

        //obtenemos el sentido a partir del signo del order
        $sentido = $order > 0 ? ' ASC ' : ' DESC ';

        //nos quedamos con en valor absoluto del order para indicar la columna por la que ordenar
        $order = abs($order);

        //calculamos el offset según la página
        $offset = ($page - 1) * $sizePage;

        if (!empty($filtros['condiciones'])) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(' AND ', $filtros['condiciones'])
                . " ORDER BY " . self::COLUMNS_ORDER[$order - 1] . $sentido
                . " LIMIT " . $offset . ", " . $sizePage;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE
                . " ORDER BY " . self::COLUMNS_ORDER[$order - 1] . $sentido
                . " LIMIT " . $offset . ", " . $sizePage);
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProveedorId(int $idProveedor): bool|array
    {
        $sql = "SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_proveedor' => $idProveedor]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteProveedor(int $idProveedor): bool
    {
        $sql = "DELETE FROM proveedor WHERE id_proveedor = :id_proveedor";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_proveedor' => $idProveedor]);

        $resultado = $stmt->rowCount();

        return ( $resultado && $resultado === 1);
    }
}
