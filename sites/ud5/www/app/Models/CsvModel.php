<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use InvalidArgumentException;

class CsvModel
{
    private string $filename;
    public const COL_MUNICIPIO = 0;
    public const COL_SEXO = 1;
    public const COL_PERIODO = 2;


    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException("El fichero '$filename' no existe");
        } else {
            $this->filename = $filename;
        }
    }

    public function getPoblacion(): array
    {
        $csvFile = file($this->filename);

        $data = [];

        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line, ';');
        }

        return $data;
    }

    public function addMunicipio(array $datosMunicipio): bool
    {
        //si hay un warning lo tranasforma e un una excepción para que se pueda manejar y mostrar un mensaje
        set_error_handler(function () {
            throw new \ErrorException('No se ha podido insertar el municipio');
        }, E_WARNING);
        $resource = fopen('../app/Data/poblacion_pontevedra.csv', 'a');
        $resultadoOperacion = fputcsv($resource, $datosMunicipio, ';');
        fclose($resource);
        //Debememos reiniciarlo para que no nos genere problemas más adelante
        restore_error_handler();
        if ($resultadoOperacion) {
            return true;
        } else {
            return false;
        }
    }

    private function checkDatosRepetidos(string $municipio, string $sexo, int $periodo): bool
    {
        //si hay un warning lo tranasforma e un una excepción para que se pueda manejar y mostrar un mensaje
        set_error_handler(function () {
            throw new \ErrorException('No se ha podido insertar el municipio');
        }, E_WARNING);
        $datos = $this->getPoblacion();

        //Debememos reiniciarlo para que no nos genere problemas más adelante
        restore_error_handler();
        $existe = false;

        foreach ($datos as $fila) {
            if (
                ($fila[self::COL_MUNICIPIO] === $municipio) &&
                ($fila[self::COL_SEXO] === $sexo) &&
                ($fila[self::COL_PERIODO] === $periodo)
            ) {
                $existe = true;
            }
        }

        return $existe;
    }
}
