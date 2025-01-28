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

    public function find(string $codigo): false|array
    {
        $sql = "SELECT * FROM producto WHERE codigo = :codigo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['codigo' => $codigo]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
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
        if(!empty($data['nombre'])){
            $condiciones[] = " nombre LIKE :nombre ";
            $nombre = $data['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //proveedor
        if(!empty($data['proveedor'])){
            $condiciones[] = " proveedor = :proveedor ";
            $vars['proveedor'] = $data['proveedor'];
        }

        //coste mínimo y maximo
        if(!empty($data['min_coste'])){
            $condiciones[] = " coste >= :min_coste ";
            $vars['min_coste'] = $data['min_coste'];
        }
        if(!empty($data['max_coste'])){
            $condiciones[] = " coste <= :max_coste ";
            $vars['max_coste'] = $data['max_coste'];
        }

        //margen
        if(!empty($data['margen'])){
            $condiciones[] = " margen = :margen ";
            $vars['margen'] = $data['margen'];
        }

        //stock mínimo y máximo
        if(!empty($data['min_stock'])){
            $condiciones[] = " margen >= :min_stock ";
            $vars['min_stock'] = $data['min_stock'];
        }
        if(!empty($data['max_stock'])){
            $condiciones[] = " margen <= :max_stock ";
            $vars['max_stock'] = $data['max_stock'];
        }

        //iva
        if(!empty($data['iva'])){
            $condiciones[] = " iva = :iva ";
            $vars['iva'] = $data['iva'];
        }

        //id_categoria
        if(!empty($data['id_categoria'])){
            $condiciones[] = " id_categoria = :id_categoria ";
            $vars['id_categoria'] = $data['id_categoria'];
        }


        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;
        return $resultado;
    }
}
