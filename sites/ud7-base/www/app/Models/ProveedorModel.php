<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{

    private const SELECT_BASE = ' SELECT pv.*, count(pd.codigo) as total_productos_proveedor ' . self::FROM;
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


    public function listProveedoresFiltered(array $data, int $order, string $sentido, int $page, int $sizePage): array|false
    {
        $filtros = $this->filtrosQuery($data);

        $order = abs($order);

        $offset = ($page - 1) * $sizePage;

        if ($filtros['conditionsWhere'] !== [] || $filtros['conditionsHaving'] !== []) {
            $sql = self::SELECT_BASE
                . (!empty($filtros['conditionsWhere']) ? " WHERE " . implode(' AND ', $filtros['conditionsWhere']) : '')
                . self::GROUP_BY
                . (!empty($filtros['conditionsHaving']) ? " HAVING " . implode(' AND ', $filtros['conditionsHaving']) : '')
                . " ORDER BY " . self::COLUMNS_ORDER[$order - 1] . ' ' . $sentido
                . " LIMIT $offset, $sizePage";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE . self::GROUP_BY
                . ' ORDER BY ' . self::COLUMNS_ORDER[$order - 1] . ' ' . $sentido
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
            $modelProducto = new ProductosModel();
            $productos = $modelProducto->findSinProveedor($proveedor['cif']);
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
        $conditionsWhere = [];
        $vars = [];
        $conditionsHaving = [];


        //cif
        if (!empty($data['cif'])) {
            $conditionsWhere[] = ' pv.cif LIKE :cif ';
            $cif = $data['cif'];
            $vars['cif'] = "%$cif%";
        }

        //nombre
        if (!empty($data['nombre'])) {
            $conditionsWhere[] = '  pv.nombre LIKE :nombre ';
            $nombre = $data['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //codigo
        if (!empty($data['codigo'])) {
            $conditionsWhere[] = '  pv.codigo LIKE :codigo ';
            $codigo = $data['codigo'];
            $vars['codigo'] = "%$codigo%";
        }

        //email
        if (!empty($data['email'])) {
            $conditionsWhere[] = '  pv.email LIKE :email ';
            $email = $data['email'];
            $vars['email'] = "%$email%";
        }

        //pais
        if (!empty($data['pais'])) {
            $conditionsWhere[] = '  pv.pais = :pais ';
            $vars['pais'] = $data['pais'];
        }

        //productos minimos
        if (!empty($data['min_productos'])) {
            $conditionsHaving[] = ' total_productos_proveedor >=:min_productos ';
            $vars['min_productos'] = (int)$data['min_productos'];
        }

        //productos máximos
        if (!empty($data['max_productos'])) {
            $conditionsHaving[] = ' total_productos_proveedor <= :max_productos ';
            $vars['max_productos'] = (int)$data['max_productos'];
        }

        $respuesta['conditionsWhere'] = $conditionsWhere;
        $respuesta['vars'] = $vars;
        $respuesta['conditionsHaving'] = $conditionsHaving;


        return $respuesta;
    }

    public function getMaxPage(array $data, int $sizePage): int
    {
        //realizamos una consulta siguiendo los filtros introducidos
        //calculamos el número de filas obtenidas
        //hacemos la repartición de filas entre las páginas según el tamaño indicado

        $filtros = $this->filtrosQuery($data);

        if ($filtros['conditionsWhere'] !== [] || $filtros['conditionsHaving'] !== []) {
            $sql = self::COUNT_BASE
                .(!empty($filtros['conditionsWhere']) ? " WHERE " . implode(' AND ', $filtros['conditionsWhere']) : '')
                . self::GROUP_BY
                .(!empty($filtros['conditionsHaving']) ? " HAVING " . implode(' AND ', $filtros['conditionsHaving']) : '');
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

    public function deleteProveedor(string $cif): bool
    {
        $sql = 'DELETE FROM proveedor WHERE cif = :cif';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);
        return ($stmt->rowCount() == 1);
    }

    public function editProveedor(string $oldCif, array $data): bool
    {
        $sql = 'UPDATE proveedor SET cif = :cif, codigo = :codigo, nombre =:nombre, direccion = :direccion, website = :website, pais = :pais, email = :email, telefono = :telefono WHERE cif = :oldCif';
        $stmt = $this->pdo->prepare($sql);
        $data['oldCif'] = $oldCif;
        $stmt->execute($data);
        return ($stmt->rowCount() === 1);
    }
}
