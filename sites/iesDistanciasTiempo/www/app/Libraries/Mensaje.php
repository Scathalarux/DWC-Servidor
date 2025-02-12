<?php

declare(strict_types=1);

namespace Com\Daw2\Libraries;

use App\Libraries\TipoMensaje;

class Mensaje
{
    /* Simulamos un enumerado*/
    public const INFO = 'info';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    public const ERROR = 'danger';

    public const ALLOWED_TYPES = [self::INFO, self::SUCCESS, self::WARNING, self::ERROR];
    /*Son privadas para que no se puedan modificar, al no poder introducir el tipo readonly*/
    public function __construct(private string $texto, private string $tipoMensaje, private string $titulo = '')
    {
        if (!in_array($tipoMensaje, self::ALLOWED_TYPES)) {
            throw new \InvalidArgumentException("El tipo de mensaje $tipoMensaje no es válido");
        }
    }

    /**
     * @return string
     */
    public function getTexto(): string
    {
        return $this->texto;
    }

    /**
     * @return string
     */
    public function getTipoMensaje(): string
    {
        return $this->tipoMensaje;
    }

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }
}
