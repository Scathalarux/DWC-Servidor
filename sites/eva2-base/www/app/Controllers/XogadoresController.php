<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\XogadoresModel;
use Decimal\Decimal;
use PDOException;

class XogadoresController extends BaseController
{
    public function listarXogadores(): void
    {
        //Licencia, nombre, nacionalidad, equipo, club
        // = , like , multiple, = , like

        $xogadoresModel = new XogadoresModel();

        $xogadores = $xogadoresModel->getFilteredXogadores($_GET);
        if ($xogadores === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'no hay xogadores que mostrar']);
        } else {
            $respuesta = new Respuesta(200, $xogadores);
        }


        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }

    public function getXogador(int $numLicencia): void
    {
        $xogadoresModel = new XogadoresModel();

        $xogador = $xogadoresModel->getXogador($numLicencia);
        if ($xogador === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'no existe el xogador']);
        } else {
            $respuesta = new Respuesta(200, $xogador);
        }

        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }

    public function deleteXogador(int $numLicencia): void
    {
        $xogadoresModel = new XogadoresModel();
        $xogador = $xogadoresModel->getXogador($numLicencia);

        if ($xogador === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'no existe el xogador']);
        } else {
            try {
                if (isset($e))
                    $resultado = $xogadoresModel->deleteXogador($numLicencia);
                if ($resultado === false) {
                    $respuesta = new Respuesta(404, ['mensaje' => 'Xogador no eliminado']);
                } else {
                    $respuesta = new Respuesta(200, ['mensaje' => 'Xogador eliminado']);
                }

            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $respuesta = new Respuesta(422, ['mensaje' => 'No se puede eliminar un xogador que tenga dependencias']);
                }
            }
        }
        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }

    public function addXogador(): void
    {
        $xogadoresModel = new XogadoresModel();
        $xogador = $xogadoresModel->getXogador($_POST["numero_licencia"]);
        if ($xogador !== false) {
            $respuesta = new Respuesta(400, ['mensaje' => 'ya existe un xogador con ese número de licencia']);
        } else {
            $errores = $this->checkForm($_POST, true);
            if ($errores === []) {
                //nacionalidade si no aparece será null
                //ficha si no aparece será ''

            } else {
                $respuesta = new Respuesta(400, ['mensaje' => $errores]);
            }

        }
        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }

    public function checkForm(array $data, bool $required): array
    {
        $errores = [];

        //numero_licencia
        if (!empty($data['numero_licencia'])) {
            if (!preg_match('/[1-9][\p{N}]{0,}/', $data['numero_licencia'])) {
                $errores['numero_licencia'] = 'El numero de licencia debe estar compuesto por números, iniciando desde el 1';
            }

        } elseif ($required) {
            $errores['numero_licencia'] = 'El numero de licencia es obligatorio';
        }

        //codigo_equipo
        if (!empty($data['codigo_equipo'])) {
            if (!preg_match('/[\p{L}]{3,4}/', $data['codigo_equipo'])) {
                $errores['codigo_equipo'] = 'El codigo equipo debe estar compuesto por 3 o 4 letras';
            }

        } elseif ($required) {
            $errores['codigo_equipo'] = 'El codigo equipo es obligatorio';
        }

        //numero
        if (!empty($data['numero'])) {
            if (!preg_match('/[\p{N}]{1,2}/', $data['numero'])) {
                $errores['numero'] = 'El numero debe estar compuesto por 1 o 2 cifras';
            } elseif ($data['numero'] < 0) {
                $errores['numero'] = 'El numero debe estar compuesto por cifras entre el 0 y el 99';
            }

        } elseif ($required) {
            $errores['numero'] = 'El numero es obligatorio';
        }
        //nome
        if (!empty($data['nome'])) {
            if (!preg_match('/^[\p{L}]{2,15}, [\p{L}]{2,15}$/iu', $data['nome'])) {
                $errores['nome'] = 'El nombre debe estar compuesto por apellido, seguido de una come y un espacio y el nombre';
            }

        } elseif ($required) {
            $errores['nome'] = 'El nombre es obligatorio';
        }

        //posicion
        if (!empty($data['posicion'])) {
            if (!preg_match('/^\p{N}$/', $data['posicion'])) {
                $errores['posicion'] = 'La posición debe estar compuesto por 1 letra';
            } elseif (in_array($data['posicion'], ['P', 'B', 'F', 'A', 'E'])) {
                $errores['posicion'] = 'La posición debe ser A, B, E, F o P';
            }

        } elseif ($required) {
            $errores['posicion'] = 'La posición es obligatoria';
        }

        //nacionalidade
        if (!empty($data['nacionalidade'])) {
            if (!preg_match('/[\p{N}]{3}/', $data['nacionalidade'])) {
                $errores['nacionalidade'] = 'La nacionalidad debe estar compuesta por 3 letras';
            }

        }

        //ficha
        if (!empty($data['ficha'])) {
            if (!preg_match('/[\p{N}]{3}/', $data['ficha'])) {
                $errores['ficha'] = 'La ficha debe estar compuesta por 3 letras';
            }

        }

        //estatura
        if (!empty($data['estatura'])) {
            if (filter_var($data['estatura'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['estatura'] = 'La estatura debe ser de tipo decimal';
            }else{
                $estatura = new Decimal($data['estatura']);
                if($estatura !== $estatura->round(2)){
                    $errores['estatura'] = 'La estatura debe ser de tipo 1 número con 2 decimales';
                }
            }

        } elseif ($required) {
            $errores['estatura'] = 'La estatura es obligatoria';
        }

        //data_nacemento
        if (!empty($data['data_nacemento'])) {

            if (!preg_match('/^(?:0[1-9]|[12]\d|3[01])([\/.-])(?:0[1-9]|1[012])\1(?:19|20)\d\d$/', $data['data_nacemento'])) {
                $errores['data_nacemento'] = 'El numero de licencia debe estar compuesto por números, iniciando desde el 1';
            }

        } elseif ($required) {
            $errores['data_nacemento'] = 'El numero de licencia es obligatorio';
        }
        //temporadas
        if (!empty($data['numero_licencia'])) {
            if (!preg_match('/[1-9][\p{N}]{0,}/', $data['numero_licencia'])) {
                $errores['numero_licencia'] = 'El numero de licencia debe estar compuesto por números, iniciando desde el 1';
            }

        } elseif ($required) {
            $errores['numero_licencia'] = 'El numero de licencia es obligatorio';
        }

        return $errores;
    }

    public function editXogadorPut(): void
    {

    }

    public function editXogadorPatch()
    {
    }
}