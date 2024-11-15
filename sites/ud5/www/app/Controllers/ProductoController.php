<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class ProductoController extends BaseController
{
    public const BASE_QUERY = "SELECT *
                                FROM productos pr
                                JOIN proveedor pv ON pv.cif = pr.proveedor";

    public function getAllProducts(): array
    {
    }
}
