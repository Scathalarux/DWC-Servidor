<?php
declare(strict_types=1);

namespace TestClasses\Daw2\Clases;

class Proveedor
{

    public function __construct(public string $cif, public string $codigo, public string $nombre, public ?string $direccion, public ?string $website, public ?string $pais, public ?string $telefono, public ?string $email)
    {
        if (!self::checkCIF($cif)) {
            throw new \InvalidArgumentException("El CIF no es válido");

        }
        if (!is_null($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El email no es válido");

        }
        if (!is_null($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("La dirección web no es válida");

        }
        if (mb_strlen($telefono) !== 9) {
            throw new \InvalidArgumentException("El teléfono debe tener 9 números");
        }
    }

    public static function checkCIF(string $cif): bool
    {
        return preg_match("/^$/", $cif);
    }

}