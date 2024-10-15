<?php
declare(strict_types=1);

namespace TestClasses\Daw2\Clases;

class Proveedor
{

    public function __construct(public string $cif, public string $codigo, public string $nombre, public ?string $direccion, public ?string $website, public ?string $pais,public ?string $email, public ?string $telefono )
    {
        if (!self::checkCIF($cif)) {
            throw new \InvalidArgumentException("El CIF no es válido");
        }
        /*if (!is_null($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El email no es válido");
        }
        if (!is_null($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("La dirección web no es válida");
        }
        if (mb_strlen($telefono) !== 9) {
            throw new \InvalidArgumentException("El teléfono debe tener 9 números");
        }*/
    }

    public static function checkCIF(string $cif): bool
    {
        return preg_match("/^[KPQS][0-9]{7}[A-Z]$/", $cif) || preg_match("/^[ABEH][0-9]{8}$/", $cif) || preg_match("/^[CDFGLMN][0-9]{7}[A-Z0-9]$/", $cif);
    }

    /**
     * @return string
     */
    public function getCif(): string
    {
        return $this->cif;
    }

    /**
     * @return string
     */
    public function getCodigo(): string
    {
        return $this->codigo;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return string|null
     */
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @return string|null
     */
    public function getPais(): ?string
    {
        return $this->pais;
    }

    /**
     * @return string|null
     */
    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }


}