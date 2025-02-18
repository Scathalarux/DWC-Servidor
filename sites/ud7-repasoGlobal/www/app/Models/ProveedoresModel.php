<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use Google\Service\OnDemandScanning\PackageData;
use PDO;

class ProveedoresModel extends BaseDbModel
{

    /**
     * Función que devuelve los datos de un proveedor, junto a sus productos, en caso de que exista
     * @param string $cif
     * @return array|false
     */
    public function getProveedorByCif(string $cif): array|false
    {
        $sql = 'SELECT pv.cif, pv.codigo, pv.nombre as nombre_proveedor, pv.direccion, pv.website as sitio_web, pv.pais, pv.email, pv.telefono, count(pd.codigo) as total_productos_proveedor
                FROM proveedor pv
                LEFT JOIN producto pd ON pd.proveedor = pv.cif
                WHERE cif = :cif
                GROUP BY cif';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cif' => $cif]);
        $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($proveedor !== false) {
            $productosModel = new ProductosModel();
            $productos = $productosModel->getProductosProveedor($cif);
            if ($productos !== false) {
                $proveedor['productos'] = $productos;
            } else {
                $proveedor['productos'] = [];
            }
        }
        return $proveedor;
    }

    public function deleteProveedor(string $cif): bool
    {
        $sql = "DELETE FROM proveedor WHERE cif = :cif";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":cif" => $cif]);
    }
}