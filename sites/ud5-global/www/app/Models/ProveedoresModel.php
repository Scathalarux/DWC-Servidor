<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class ProveedoresModel extends BaseDbModel
{
    private const ORDER_COLUMNS = ['cif', 'codigo', 'nombre', 'pais', 'direccion', 'email'];
    private const DEFAULT_ORDER = 1;

    private const SIZE_PAGE = 25;
    private const DEFAULT_PAGE = 1;

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM proveedor order by nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProveedoresFiltrados(array $data): array
    {
        $filtros = $this->fitlrosQuery($data);

        if (!empty($data['order'])
            && filter_var($data['order'], FILTER_VALIDATE_INT)
            && abs((int)$data['order']) > 0
            && abs((int)$data['order']) <= count(self::ORDER_COLUMNS)) {
            $order = (int)$data['order'];
        } else {
            $order = self::DEFAULT_ORDER;
        }

        $sentido = $order > 0 ? ' ASC ' : ' DESC ';
        $orderAbs = abs((int)$order);

        $maxPage = $this->getMaxPage($data);

        if (!empty($data['page'])
            && filter_var($data['page'], FILTER_VALIDATE_INT)
            && (int)$data['page'] > 0
            && (int)$data['page'] <= $maxPage) {
            $page = $data['page'];
        } else {
            $page = self::DEFAULT_PAGE;
        }

        $offset = ($page - 1) * self::SIZE_PAGE;

        if ($filtros['conditions'] !== []) {
            $sql = "SELECT * FROM proveedor"
                . " WHERE " . implode(" AND ", $filtros['conditions'])
                . " ORDER BY " . self::ORDER_COLUMNS[$orderAbs - 1] . " " . $sentido
                . " LIMIT " . $offset . ", " . self::SIZE_PAGE;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = "SELECT * FROM proveedor"
                . " ORDER BY " . self::ORDER_COLUMNS[$orderAbs - 1] . " " . $sentido
                . " LIMIT " . $offset . ", " . self::SIZE_PAGE;
            $stmt = $this->pdo->query($sql);
            $stmt->execute();
        }
        return ['proveedores' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'order' => $order, 'page' => $page, 'maxPage' => $maxPage];
    }

    public function fitlrosQuery(array $data): array
    {
        $conditions = [];
        $vars = [];

        //cif
        if (!empty($data['cif'])) {
            $conditions[] = ' cif = :cif ';
            $vars['cif'] = $data['cif'];
        }

        //codigo
        if (!empty($data['codigo'])) {
            $conditions[] = ' codigo = :codigo ';
            $vars['codigo'] = $data['codigo'];
        }


        //nombre
        if (!empty($data['nombre'])) {
            $conditions[] = ' nombre LIKE :nombre';
            $vars['nombre'] = '%' . $data['nombre'] . '%';
        }

        //pais
        if (!empty($data['pais'])) {
            $varsPais = [];
            $i = 1;
            foreach ($data['pais'] as $pais) {
                $varsPais[':pais' . $i] = $pais;
            }

            $conditions[] = ' pais IN (' . implode(',', array_keys($varsPais)) . ') ';
            $vars = array_merge($varsPais, $vars);
        }

        //email
        if (!empty($data['email'])) {
            $conditions[] = ' email LIKE :email';
            $vars['email'] = '%' . $data['email'] . '%';
        }

        //telefono
        if (!empty($data['telefono'])) {
            $conditions[] = ' telefono = :telefono ';
            $vars['telefono'] = $data['telefono'];
        }

        return ['conditions' => $conditions, 'vars' => $vars];
    }

    public function getMaxPage(array $data): int
    {
        $filtros = $this->fitlrosQuery($data);
        if ($filtros['conditions'] !== []) {
            $sql = "SELECT COUNT(*) FROM proveedor"
                . " WHERE " . implode(" and ", $filtros['conditions']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = "SELECT COUNT(*) FROM proveedor";
            $stmt = $this->pdo->query($sql);
            $stmt->execute();
        }

        $rows = $stmt->fetchColumn(0);
        return (int)ceil($rows / self::SIZE_PAGE);
    }

    public function getProveedor(string $cif): array|false
    {
        $sql = "SELECT * FROM proveedor where cif = :cif";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteProveedor(string $cif): bool
    {
        $sql = "DELETE FROM proveedor where cif = :cif";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['cif' => $cif]);
    }

    public function addProveedor(array $data): bool
    {
        $sql = "INSERT INTO proveedor (cif, codigo, nombre, direccion, website, pais, email, telefono) 
            VALUES (:cif, :codigo, :nombre, :direccion, :website, :pais, :email, :telefono)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function editProveedor(string $oldCif, array $data): bool
    {
        $sql = "UPDATE proveedor SET cif=:cif, codigo=:codigo, nombre=:nombre, direccion=:direccion, website=:website, pais=:pais, email=:email, telefono=:telefono 
                WHERE cif=:oldCif";
        $stmt = $this->pdo->prepare($sql);
        $data['oldCif'] = $data['cif'];
        return $stmt->execute($data);
    }

    public function getPaises(): array
    {
        $stmt = $this->pdo->query("SELECT pais from proveedor group by pais order by pais asc");
        return $stmt->fetchAll(pdo::FETCH_ASSOC);
    }
}