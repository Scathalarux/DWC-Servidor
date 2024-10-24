<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CsvModel;

class CsvController extends BaseController
{
    //Podemos crear una constante y luego concatenarla al nombre del archivo cuando lo llamo
//    private const DATA_FOLDER = '../app/Data/';

    public const SEXOS = ['-', 'Hombre', 'Mujer', 'Total'];

    public function showPoblacionPontevedra(): void
    {

        $vars = array(
            'titulo' => 'Histótico población Pontevedra',
            'breadcrumb' => array('Inicio', 'Historico poblacion Pontevedra'),
            'seccion' => '/historicoPoblacionPontevedra',
            /*'csv_div_titulo' => 'Datos del CSV',
            'js' => array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'assets/js/pages/csv.view.js')*/
        );

        $csvModel = new CsvModel('../app/Data/poblacion_pontevedra.csv');
        $vars['data'] = $csvModel->getPoblacion();
        //comprobamos cual es el mayor y el menor
        if (count($vars['data']) > 1) {
            $vars = array_merge($vars, $this->getMinMaxPo($vars['data']));
            $vars['showMinMax'] = true;
        }
        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $vars);
    }

    /**
     * Funcion que elimina el punto del string que delimita los miles y lo devuelve en forma de int
     * @param string $poblacion
     * @return int
     */
    private function cleanNumPoblacion(string $poblacion): int
    {
        return (int)str_replace('.', '', $poblacion);
    }

    /**
     * Función que calcula el municipio con menor y mayor población
     * @param $registros
     * @return array
     */
    private function getMinMaxPo($registros): array
    {
        $min = $registros[1];
        $max = $registros[1];
        //Quitamos el punto por si genera errores
        $min[3] = $this->cleanNumPoblacion($min[3]);
        $max[3] = $this->cleanNumPoblacion($max[3]);


        for ($i = 1; $i < count($registros); $i++) {
            $actual = $registros[$i];
            //solo recorremos tupla si es la representacion de un int (evitamos lo vacío)
            if (filter_var($actual[3], FILTER_VALIDATE_INT)) {
                $poblacionActual = $this->cleanNumPoblacion($actual[3]);
                if ($min[3] > $poblacionActual) {
                    $min = $actual;
                    $min[3] = $this->cleanNumPoblacion($min[3]);
                }
                if ($max[3] < $poblacionActual) {
                    $max = $actual;
                    $max = $this->cleanNumPoblacion($max[3]);
                }
            }
        }

        $resultados = [];
        $resultados['min'] = $min;
        $resultados['max'] = $max;

        return $resultados;
    }

    public function showPoblacionGruposEdad(): void
    {
        $vars = array(
            'titulo' => 'Población Grupos Edad',
            'breadcrumb' => array('Inicio', 'Población Grupos Edad'),
            'seccion' => '/poblacionGruposEdad',
        );

        $csvModel = new CsvModel('../app/Data/poblacion_grupos_edad.csv');

        $vars['data'] = $csvModel->getPoblacion();
        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $vars);
    }

    public function showPoblacionPontevedra2020(): void
    {
        $vars = [
            'titulo' => 'Población Pontevedra 2020',
            'breadcrumb' => ['Csv', 'Población Pontevedra 2020'],
            'seccion' => '/poblacionPontevedra2020'
        ];
        $model = new CsvModel('../app/Data/poblacion_pontevedra_2020_totales.csv');
        $vars['data'] = $model->getPoblacion();

        if (count($vars['data']) > 1) {
            $vars = array_merge($vars, $this->getMinMaxPo($vars['data']));
            $vars['min'][1] = '';
            $vars['min'][2] = '';
            $vars['max'][1] = '';
            $vars['max'][2] = '';
        }
        $vars['showMinMax'] = false;

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $vars);
    }

    public function showAnadirPoblacion()
    {
        $vars = [
            'titulo' => 'Añadir Población',
            'breadcrumb' => ['Csv', 'Añadir Población'],
            'seccion' => '/añadirPoblacion',
            'sexos' => self::SEXOS
        ];
        $this->view->showViews(array('templates/header.view.php', 'addCsv.view.php', 'templates/footer.view.php'), $vars);
    }

    //formulario para añadir una fila al fichero
    public function addRow(): void
    {
        $vars = [
            'titulo' => 'Añadir Población',
            'breadcrumb' => ['Csv', 'Añadir Población'],
            'seccion' => '/añadirPoblacion',
            'sexos' => self::SEXOS
        ];
        $model = new CsvModel('../app/Data/poblacion_pontevedra.csv');
        $vars['data'] = $model->getPoblacion();

        if (isset($_POST['submit'])) {
            $errores = $this->checkDatosMunicipio($_POST['submit']);
            $vars['input'] = filter_var($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            if (count($errores) > 0) {
                $vars['errores'] = $errores;
            } else {
                //Metemos los datos si no hay elementos
                if ($this->checkDatoRepetido($_POST['submit'])) {
                    $nombre = $_POST['nombre'];
                    $periodo = $_POST['periodo'];
                    $sexo = $_POST['sexo'];
                    $poblacion = $_POST['total'];

                    $registro = [$nombre, $sexo, $periodo, $poblacion];

                    $model->addMunicipio($registro);
                }
            }
        }
        $this->view->showViews(array('templates/header.view.php', 'addCsv.view.php', 'templates/footer.view.php'), $vars);
    }

    private function checkDatoRepetido($poblacion): bool
    {
        $noExiste = true;

        for ($i = 0; $i < count($poblacion); $i++) {
            for ($j = 0; $j < count($poblacion[$i]); $j++) {
                if (($poblacion['nombre'] | $poblacion['periodo'] | $poblacion['sexo']) === $poblacion[$i][$j]) {
                    $noExiste = false;
                }
            }
        }
        return $noExiste;
    }

    private function checkDatosMunicipio($poblacion): array
    {
        $errores = [];

        //Comprobamos el nombre del municipio
        if (mb_strlen($poblacion['nombre']) < 1) {
            $errores['nombre'] = 'El nombre del municipio debe tener al menos 1 caracter';
        } elseif (!preg_match('/^[1-9]([0-9]|[0-9]{4})\p{L}[\p{L}\s]*$]/iu', $poblacion['nombre'])) {
            $errores['nombre'] = 'El nombre del municipio solo puede contener el CP (2 o 5 cifras) seguido letras y espacios';
        }

        //comprobamos el sexo
        if (!in_array($poblacion['sexo'], self::SEXOS)) {
            $errores['sexo'] = "El sexo debe ser '-', 'Hombre', 'Mujer' o 'Total'";
        }

        //comprobamos el periodo del municipio
        if (!filter_var($poblacion['periodo'], FILTER_VALIDATE_INT)) {
            $errores['periodo'] = 'El periodo debe ser un número entero';
        } elseif ((int)(date('Y') - (int)$poblacion['periodo']) < 0 || (int)(date('Y') - (int)$poblacion['periodo']) > 100) {
            $errores['periodo'] = 'El periodo debe estar entre hace 100 años y el año actual';
        }


        //comprobamos el número de la población
        if (!filter_var($poblacion['total'], FILTER_VALIDATE_INT)) {
            $errores['total'] = 'El periodo debe ser un número entero';
        } else {
            if ($poblacion['total'] < 0) {
                $errores['total'] = 'El periodo debe ser mayor a 0';
            }
        }

        return $errores;
    }
}
