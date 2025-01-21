<?php

declare(strict_types=1);

namespace Com\Daw2\Traits;

trait BaseRestController
{
    public function initBodyData(): array
    {
        $peticion = file_get_contents('php://input');
        if (!empty($peticion)) {
            $typeContenido = $_SERVER["CONTENT_TYPE"] ?? 'plain/text';
            if ($typeContenido == 'application/json') {
                $vars = json_decode($peticion, true);
            } elseif ($typeContenido == 'application/x-www-form-urlencoded') {
                //parsea string a variables y lo almacena en la variable indicada
                parse_str($peticion, $vars);
            } elseif (str_starts_with($typeContenido,'multipart/form-data')) {
                $vars= $this->getMultipartData();
            } else {
                //al no ser un caso específico, lo establecemos como default y lo ponemos a parte
                parse_str($peticion, $vars);
            }
            return $vars;
        }
        return [];
    }

    public function getMultipartData()
    {

    }
}