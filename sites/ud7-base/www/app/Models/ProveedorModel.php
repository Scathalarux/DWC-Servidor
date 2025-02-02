<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{

    private const SELECT_BASE = ' SELECT pv.*, count(*) as total_productos_proveedor ' . self::FROM;
    private const FROM = ' FROM proveedor pv
                            LEFT JOIN producto pd ON pd.proveedor = pv.cif';

    private const GROUP_BY = ' GROUP BY pv.cif ';
    private const COUNT_BASE = 'SELECT COUNT(*) ' . self::FROM;
    public const COLUMNS_ORDER = ['cif', 'codigo', 'nombre', 'pais', 'total_productos_proveedor'];

    public function find(string $cif): false|array
    {
        $sql = "SELECT * FROM proveedor WHERE cif = :cif";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);
        return $stmt->fetch();
    }


    public function listProveedoresFiltered(array $data, int $order, int $page, int $sizePage): array|false
    {
        $filtros = $this->filtrosQuery($data);

        $sentido = $order > 0 ? ' ASC ' : ' DESC ';

        $order = abs($order);

        $offset = ($page - 1) * $sizePage;

        if ($filtros['conditions'] !== []) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(' AND ', $filtros['conditions'])
                . self::GROUP_BY
                . ' ORDER BY ' . self::COLUMNS_ORDER[$order - 1] . $sentido
                . " LIMIT $offset, $sizePage";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE . self::GROUP_BY
                . ' ORDER BY ' . self::COLUMNS_ORDER[$order - 1] . $sentido
                . " LIMIT $offset, $sizePage");
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProveedor(string $cif): false|array
    {
        $sql1 = "SELECT * FROM proveedor WHERE cif = :cif";
        $stmt = $this->pdo->prepare($sql1);
        $stmt->execute(['cif' => $cif]);
        $proveedor = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($proveedor !== false) {
            $sql2 = "SELECT * FROM producto WHERE proveedor = :cif";
            $stmt = $this->pdo->prepare($sql2);
            $stmt->execute(['cif' => $cif]);
            $productos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $proveedor['productos'] = $productos;
        }
        return $proveedor;
    }

    public function getProveedorCodigo(string $codigo): false|array
    {
        $sql1 = "SELECT * FROM proveedor WHERE codigo = :codigo";
        $stmt = $this->pdo->prepare($sql1);
        $stmt->execute(['codigo' => $codigo]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $conditions = [];
        $vars = [];

        //cif
        if (!empty($data['cif'])) {
            $conditions[] = ' pv.cif LIKE :cif ';
            $cif = $data['cif'];
            $vars['cif'] = "%$cif%";
        }

        //nombre
        if (!empty($data['nombre'])) {
            $conditions[] = '  pv.nombre LIKE :nombre ';
            $nombre = $data['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //codigo
        if (!empty($data['codigo'])) {
            $conditions[] = '  pv.codigo LIKE :codigo ';
            $codigo = $data['codigo'];
            $vars['codigo'] = "%$codigo%";
        }

        //email
        if (!empty($data['email'])) {
            $conditions[] = '  pv.email LIKE :email ';
            $email = $data['email'];
            $vars['email'] = "%$email%";
        }

        //pais
        if (!empty($data['pais'])) {
            $conditions[] = '  pv.pais = :pais ';
            $vars['pais'] = $data['pais'];
        }

        //productos minimos
        if (!empty($data['min_productos'])) {
            $conditions[] = ' total_productos_proveedor >=:min_productos ';
            $vars['min_productos'] = $data['min_productos'];
        }

        //productos máximos
        if (!empty($data['max_productos'])) {
            $conditions[] = ' total_productos_proveedor <= :max_productos ';
            $vars['max_productos'] = $data['max_productos'];
        }

        $respuesta['conditions'] = $conditions;
        $respuesta['vars'] = $vars;

        return $respuesta;
    }

    public function getMaxPage(array $data, int $sizePage): int
    {
        //realizamos una consulta siguiendo los filtros introducidos
        //calculamos el número de filas obtenidas
        //hacemos la repartición de filas entre las páginas según el tamaño indicado

        $filtros = $this->filtrosQuery($data);

        if ($filtros['conditions'] !== []) {
            $sql = self::COUNT_BASE
                . " WHERE " . implode(' AND ', $filtros['conditions'])
                . self::GROUP_BY;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::COUNT_BASE . self::GROUP_BY);
        }
        $rows = $stmt->rowCount();

        return (int)ceil($rows / $sizePage);
    }

    public function addProveedor(array $data): false|int
    {
        $sql = 'INSERT INTO proveedor (cif, codigo, nombre, direccion, website, pais, email, telefono) VALUES (:cif, :codigo, :nombre_proveedor, :direccion, :website, :pais, :email, :telefono)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        $id = $stmt->rowCount();
        if ($id == 1) {
            return (int)$id;
        } else {
            return false;
        }
    }
}
