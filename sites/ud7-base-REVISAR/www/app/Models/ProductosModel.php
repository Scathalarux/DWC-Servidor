<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductosModel extends BaseDbModel
{
    public function getAll(): array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM producto ORDER BY nombre ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findCodigo(string $codigo): false|array
    {
        $sql = "SELECT * FROM producto WHERE codigo = :codigo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['codigo' => $codigo]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findSinProveedor(string $proveedorCif): array
    {
        $sql = "SELECT codigo, nombre, descripcion, coste, margen, iva, stock FROM producto WHERE proveedor = :proveedor";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['proveedor' => $proveedorCif]);
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(!$resultado){
            return [];
        }else{
            return $resultado;
        }
    }

    public function getFiltered(array $data): array
    {
        $filtros = $this->filtrosQuery($data);

        if ($filtros['condiciones'] !== []) {
            $sql = "SELECT * FROM producto"
                . " WHERE " . implode(" AND ", $filtros['condiciones']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM producto ORDER BY nombre ASC");
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $condiciones = [];
        $vars = [];
        //codigo
        if (!empty($data['codigo'])) {
            $condiciones[] = " codigo LIKE :codigo ";
            $codigo = $data['codigo'];
            $vars['codigo'] = "%$codigo%";
        }

        //nombre
        if (!empty($data['nombre'])) {
            $condiciones[] = " nombre LIKE :nombre ";
            $nombre = $data['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //proveedor
        if (!empty($data['proveedor'])) {
            $condiciones[] = " proveedor = :proveedor ";
            $vars['proveedor'] = $data['proveedor'];
        }

        //coste mínimo y maximo
        if (!empty($data['min_coste'])) {
            $condiciones[] = " coste >= :min_coste ";
            $vars['min_coste'] = $data['min_coste'];
        }
        if (!empty($data['max_coste'])) {
            $condiciones[] = " coste <= :max_coste ";
            $vars['max_coste'] = $data['max_coste'];
        }

        //margen
        if (!empty($data['margen'])) {
            $condiciones[] = " margen = :margen ";
            $vars['margen'] = $data['margen'];
        }

        //stock mínimo y máximo
        if (!empty($data['min_stock'])) {
            $condiciones[] = " margen >= :min_stock ";
            $vars['min_stock'] = $data['min_stock'];
        }
        if (!empty($data['max_stock'])) {
            $condiciones[] = " margen <= :max_stock ";
            $vars['max_stock'] = $data['max_stock'];
        }

        //iva
        if (!empty($data['iva'])) {
            $condiciones[] = " iva = :iva ";
            $vars['iva'] = $data['iva'];
        }

        //id_categoria
        if (!empty($data['id_categoria'])) {
            $condiciones[] = " id_categoria = :id_categoria ";
            $vars['id_categoria'] = $data['id_categoria'];
        }


        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;
        return $resultado;
    }

    public function addProducto(array $data): bool
    {
        $sql = "INSERT INTO producto (codigo, nombre, descripcion, proveedor, coste, margen, stock, iva, id_categoria) VALUES (:codigo, :nombre, :descripcion, :proveedor, :coste, :margen, :stock, :iva, :id_categoria)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteProducto(string $codigo):bool
    {
        $sql = "DELETE FROM producto WHERE codigo = :codigo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['codigo' => $codigo]);
        return ($stmt->rowCount() === 1);

    }

    public function editProducto(array $data, string $oldCodigo): bool
    {
        $sql = "UPDATE producto SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, proveedor = :proveedor, coste = :coste, margen =:margen, stock = :stock, iva = :iva, id_categoria = :id_categoria WHERE codigo = :oldCodigo";
        $stmt = $this->pdo->prepare($sql);
        $data['oldCodigo'] = $oldCodigo;
        return $stmt->execute($data);
        
    }
}
