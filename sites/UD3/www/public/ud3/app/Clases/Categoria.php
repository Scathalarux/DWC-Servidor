<?php
declare(strict_types=1);

namespace TestClasses\Daw2\Clases;

class Categoria
{
    private const SEPARADOR = ' > ';

    public function __construct(private string $nombre, private ?Categoria $padre = null)
    {
        if (mb_strlen(trim($this->nombre)) === 0) {
            throw new \InvalidArgumentException("El nombre de la categoría no puede estar vacío");
        }
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return Categoria
     */
    public function getPadre(): Categoria
    {
        return $this->padre;
    }

    public function getFullName(): string
    {
        $resultado = $this->nombre;
        $padre = $this->padre;

        while(!is_null($padre)) {
            $resultado = $padre->nombre.self::SEPARADOR.$resultado;
            $padre = $padre->padre;
        }
        return $resultado;
    }
}