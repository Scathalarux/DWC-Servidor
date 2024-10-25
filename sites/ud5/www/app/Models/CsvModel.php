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

    private function checkDatosRepetido($poblacion): bool
    {
        $existe = false;

        for ($i = 1; $i < count($poblacion); $i++) {
                if (($poblacion['nombre'] === $poblacion[$i][]) && ($poblacion['periodo'] === $poblacion[$i][$j]) && ($poblacion['sexo'] === $poblacion[$i][$j])) {
                    $existe = true;
                }
        }
        return $existe;
    }
}
