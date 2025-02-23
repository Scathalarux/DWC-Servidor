<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\XogadoresModel;
use Com\Daw2\Traits\BaseRestController;
use Decimal\Decimal;
use PDOException;

class XogadoresController extends BaseController
{
    private const ALLOWED_PARAMS = ['numero_licencia', 'codigo_equipo', 'numero', 'nome', 'posicion', 'nacionalidade', 'ficha', 'estatura', 'data_nacemento', 'temporadas'];

    public function listarXogadores(): void
    {
        //Licencia, nombre, nacionalidad, equipo, club
        // = , like , multiple, = , like

        $xogadoresModel = new XogadoresModel();
        try {
            $xogadores = $xogadoresModel->getFilteredXogadores($_GET);
            if ($xogadores === false) {
                $respuesta = new Respuesta(404, ['mensaje' => 'no hay xogadores que mostrar']);
            } else {
                $respuesta = new Respuesta(200, $xogadores);
            }

        } catch (\InvalidArgumentException $e) {
            $respuesta = new Respuesta(400, ['mensaje' => $e->getMessage()]);
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

                $insertData = $_POST;
                //nacionalidade si no aparece será null
                $insertData['nacionalidade'] = !empty($_POST["nacionalidade"]) ? $_POST["nacionalidade"] : null;
                //ficha si no aparece será ''
                $insertData['ficha'] = !empty($_POST["ficha"]) ? $_POST["ficha"] : '';

                $resultado = $xogadoresModel->addXogador($insertData);
                if ($resultado === false) {
                    $respuesta = new Respuesta(200, ['mensaje' => 'Xogador añadido correctamente']);
                } else {
                    $respuesta = new Respuesta(500, ['mensaje' => 'No se pudo añadir al xogador']);
                }

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
            if (!preg_match('/^[\p{L} ]{1,15}, [\p{L} ]{1,15}$/iu', $data['nome'])) {
                $errores['nome'] = 'El nombre debe estar compuesto por apellido, seguido de una come y un espacio y el nombre';
            }

        } elseif ($required) {
            $errores['nome'] = 'El nombre es obligatorio';
        }

        //posicion
        if (!empty($data['posicion'])) {
            if (!preg_match('/^[ABEFP]$/iu', $data['posicion'])) {
                $errores['posicion'] = 'La posición debe ser una única letra: A, B, E, F o P';
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
            } else {
                $estatura = new Decimal($data['estatura']);
                if ($estatura !== $estatura->round(2)) {
                    $errores['estatura'] = 'La estatura debe ser de tipo 1 número con 2 decimales';
                }
            }

        } elseif ($required) {
            $errores['estatura'] = 'La estatura es obligatoria';
        }

        //data_nacemento
        if (!empty($data['data_nacemento'])) {

            if (!preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $data['data_nacemento'])) {
                $errores['data_nacemento'] = 'La fecha de naciemiento debe seguir el formato YYYY-MM-DD';
            }

        } elseif ($required) {
            $errores['data_nacemento'] = 'La fecha de naciemiento es obligatoria';
        }

        //temporadas
        if (!empty($data['temporadas'])) {
            if (!preg_match('/[\p{N}]{1,}/', $data['temporadas'])) {
                $errores['temporadas'] = 'El numero de temporadas debe estar compuesto por números, iniciando desde el 1';
            } elseif ((int)$data['temporadas'] < 0) {
                $errores['temporadas'] = 'El número de temporadas debe ser mayor o igual a 0';
            }

        } elseif ($required) {
            $errores['temporadas'] = 'El numero de temporadas es obligatorio';
        }

        return $errores;
    }

    use BaseRestController;

    public function editXogadorPut(int $numLicencia): void
    {
        $put = $this->getParams();

        $xogadoresModel = new XogadoresModel();
        $xogador = $xogadoresModel->getXogador($numLicencia);
        if ($xogador === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'no existe el xogador']);
        } else {
            if ($put === []) {
                $respuesta = new Respuesta(400, ['mensaje' => 'no se han introducido parámetros para la edición']);
            } else {
                $errores = $this->checkForm($put, false);
                if ($errores === []) {
                    $arrayAux = [];
                    foreach (self::ALLOWED_PARAMS as $param) {
                        if (isset($put[$param])) {
                            $arrayAux[$param] = $put[$param];
                        } else {
                            $arrayAux[$param] = $xogador[$param];
                        }
                    }

                    if ($xogadoresModel->editXogadorPut($numLicencia, $arrayAux)) {
                        $respuesta = new Respuesta(200, ['mensaje' => 'xogador editado correctamente']);
                    } else {
                        $respuesta = new Respuesta(500, ['mensaje' => 'no se pudo editar el xogador']);
                    }

                } else {
                    $respuesta = new Respuesta(404, ['mensaje' => $errores]);
                }

            }


        }

        $this->view->show('json.view.php', ['respuesta' => $respuesta]);

    }

    public function editXogadorPatch(int $numLicencia): void
    {
        $patch = $this->getParams();
        $xogadoresModel = new XogadoresModel();
        $xogador = $xogadoresModel->getXogador($numLicencia);
        if ($xogador === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'no existe el xogador']);
        } else {
            $arrayAux = [];
            foreach (self::ALLOWED_PARAMS as $param) {
                if (isset($patch[$param])) {
                    $arrayAux[$param] = $patch[$param];
                }
            }
            if ($patch === [] || $arrayAux === []) {
                $respuesta = new Respuesta(400, ['mensaje' => 'no se han pasados parámetros para la edición']);
            } else {
                $errores = $this->checkForm($arrayAux, false);
                if ($errores === []) {
                    if ($xogadoresModel->editXogadorPatch($numLicencia, $arrayAux)) {
                        $respuesta = new Respuesta(200, ['mensaje' => 'xogador actualizado correctamente']);
                    } else {
                        $respuesta = new Respuesta(500, ['mensaje' => 'xogador non actualizado']);
                    }
                } else {
                    $respuesta = new Respuesta(400, ['mensaje' => $errores]);
                }
            }
        }
        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }
}