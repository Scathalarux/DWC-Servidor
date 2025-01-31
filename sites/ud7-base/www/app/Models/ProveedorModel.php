<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{
    private const SELECT_BASE = 'SELECT pv.*, (SELECT pd.* FROM producto pd WHERE pd.proveedor =  pv.cif) as total_productos_proveedor' . self::FROM;
    private const FROM = ' FROM proveedor pv ';

    private const COUNT_BASE = 'SELECT COUNT(*) ' . self::FROM;
    public const COLUMNS_ORDER = ['cif','codigo','nombre', 'pais', 'total_productos_proveedor'];
    public function find(string $cif): false|array
    {
        $sql = "SELECT * FROM proveedor WHERE cif = :cif";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);
        return $stmt->fetch();
    }


    public function listProveedoresFiltered(array $data, int $order, int $page, int $maxPage): array|false
    {
        $filtros = $this->filtrosQuery($data);

        $sentido = $order > 0 ? ' ASC ' : ' DESC ';

        $order = abs($order);

        $offset = ($page - 1) * $maxPage;

        if ($filtros['conditions'] !== []) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(' AND ', $filtros['conditions'])
                . ' ORDER BY ' . self::COLUMNS_ORDER[$order - 1] . $sentido
                . " LIMIT $offset, $maxPage";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE
                                        . ' ORDER BY ' . self::COLUMNS_ORDER[$order - 1] . $sentido
                                        . " LIMIT $offset, $maxPage");
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $conditions = [];
        $vars = [];

        //cif
        if (!empty($data['cif'])) {
            $conditions[] = ' cif LIKE :cif';
            $cif = $data['cif'];
            $vars['cif'] = "%$cif%";
        }

        //nombre
        if (!empty($data['nombre'])) {
            $conditions[] = ' nombre LIKE :nombre';
            $nombre = $data['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //codigo
        if (!empty($data['codigo'])) {
            $conditions[] = ' codigo LIKE :codigo';
            $codigo = $data['codigo'];
            $vars['codigo'] = "%$codigo%";
        }

        //email
        if (!empty($data['email'])) {
            $conditions[] = ' email LIKE :email';
            $email = $data['email'];
            $vars['email'] = "%$email%";
        }

        //pais
        if (!empty($data['pais'])) {
            $conditions[] = ' pais = :pais';
            $vars['pais'] = $data['pais'];
        }

        //productos minimos
        if (!empty($data['min_productos'])) {
            $conditions[] = ' total_productos_proveedor >=:min_productos';
            $vars['min_productos'] = $data['min_productos'];
        }

        //productos máximos
        if (!empty($data['max_productos'])) {
            $conditions[] = ' total_productos_proveedor >=:max_productos';
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
               ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::COUNT_BASE);
        }
        $rows =  $stmt->fetchColumn(0);

        return (int)ceil($rows / $sizePage);
    }
}
