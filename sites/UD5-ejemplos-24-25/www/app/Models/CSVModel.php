<?php
namespace Com\Daw2\Models;

class CSVModel{
    private $filename;
    
    public function __construct(string $filename){
        $this->filename = $filename;
    }
    
    public function getPoblacionPontevedra() : array{
        $csvFile = file($this->filename);
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line, ';');
        }
        return $data;
    }
    
    private function getPermisos(int $tipo) : array{
        if($tipo === ADMIN){
            return array(
                'categoria' => 'rwd',
                'usuarios' => 'rwd'
            );
        }
        else if($tipo == WEB){
            return array(
                'categoria' => 'rw',
                'usuarios' => ''
            );
        }
    }
}