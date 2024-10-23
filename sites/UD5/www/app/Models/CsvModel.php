<?php
declare(strict_types=1);

namespace Com\Daw2\Models;

use InvalidArgumentException;

class CsvModel
{
    private string $filename;

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

}