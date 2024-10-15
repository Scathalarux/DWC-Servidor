<?php
declare(strict_types=1);

namespace TestClasses\Daw2\Clases;

class Producto
{

    private const IVA = array(0, 4, 10, 21);
    private array $productosRelacionados;

    public function __construct(private string $codigoProducto, private string $nombreProducto, private string $descripcionProducto, private Proveedor $proveedor, private Categoria $categoria, private float $coste, private int $margen, private int $stock, private int $iva)
    {
        if (mb_strlen(trim($this->codigoProducto)) > 10) {
            throw new \InvalidArgumentException("El código del producto debe tener máximo 10 letras/caracteres");
        } else if ($this->coste <= 0) {
            throw new \InvalidArgumentException("El coste debe ser mayor a 0");
        } else if ($this->margen <= 0) {
            throw new \InvalidArgumentException("El margen debe ser mayor a 0");
        } else if (!in_array($this->iva, self::IVA)) {
            throw new \InvalidArgumentException("El IVA debe ser 0%, 4%, 10% o 21%");
        }
    }

    public function agregarProductoRelacionado(Producto $p): void
    {
        $this->productosRelacionados[] = $p;
    }

    public function getPrecioVenta(bool $conIva): float
    {
        $precioVenta = $this->coste * (1 + ($this->margen / 100));
        if ($conIva) {
            $precioVenta += ($precioVenta * ($this->iva / 100));
        }
        return round($precioVenta, 2, PHP_ROUND_HALF_UP);
    }

    public function descontarStock(int $reduccionStock): void
    {
        if ($reduccionStock > $this->stock) {
            throw new \InvalidArgumentException("La reducción que se quiere hacer no es posible, ya que es mayor que el stock disponible");
        } else if ($this->stock <= 0) {
            throw new \InvalidArgumentException("La reducción que se quiere hacer no es posible, ya que el stock debe ser mayor a 0");
        } else {
            $this->stock -= $reduccionStock;
        }
    }

    public function agregarStock(int $agregacionStock): void
    {
        $this->stock += $agregacionStock;
    }

    /**
     * @return string
     */
    public function getCodigoProducto(): string
    {
        return $this->codigoProducto;
    }

    /**
     * @return string
     */
    public function getNombreProducto(): string
    {
        return $this->nombreProducto;
    }

    /**
     * @return string
     */
    public function getDescripcionProducto(): string
    {
        return $this->descripcionProducto;
    }

    /**
     * @return Proveedor
     */
    public function getProveedor(): Proveedor
    {
        return $this->proveedor;
    }

    /**
     * @return Categoria
     */
    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }

    /**
     * @return double
     */
    public function getCoste(): float
    {
        return $this->coste;
    }

    /**
     * @return int
     */
    public function getMargen(): int
    {
        return $this->margen;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @return int
     */
    public function getIva(): int
    {
        return $this->iva;
    }

}