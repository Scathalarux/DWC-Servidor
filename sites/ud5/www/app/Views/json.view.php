<?php

declare(strict_types=1);


header('Access-Control-Allow-Origin: http://localhost:8080');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
//aviso
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
//filtrado
header("Allow: GET, POST, PUT, DELETE");
http_response_code($respuesta->getStatus());

if ($respuesta->hasData()) {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($respuesta->getData());
}