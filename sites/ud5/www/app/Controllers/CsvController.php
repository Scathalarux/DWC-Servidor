<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CsvModel;

class CsvController extends BaseController
{
    //Podemos crear una constante y luego concatenarla al nombre del archivo cuando lo llamo
//    private const DATA_FOLDER = '../app/Data/';

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
            $vars['showMinMax'] = true ;
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
            $vars['showMinMax'] = false ;

        $this->view->showViews(array('templates/header.view.php', 'csv.view.php', 'templates/footer.view.php'), $vars);
    }

    //formulario para añadir una fila al fichero
    public function addRow(): void
    {
        $vars = [
            'titulo' => 'Añadir Población',
            'breadcrumb' => ['Csv', 'Añadir Población'],
            'seccion' => '/añadirPoblacion',
        ];
        $model = new CsvModel('../app/Data/poblacion_pontevedra.csv');
        $vars['data'] = $model->getPoblacion();

        if (isset($_POST['submit'])) {
            $errors = $this->checkDatosMunicipio($_POST['submit']);
            if (count($errors) > 0) {
                $vars['errors'] = $errors;
            } else {
                //Metemos los datos
                if ($this->checkDatoRepetido($_POST['submit'])) {
                    $nombre = $_POST['nombre'];
                    $periodo = $_POST['periodo'];
                    $sexo = $_POST['sexo'];
                    $poblacion = $_POST['total'];

                    $registro = [$nombre, $sexo, $periodo, $poblacion];

                    $resource = fopen('../app/Data/poblacion_pontevedra.csv', 'a');
                    fputcsv($resource, $registro, ';');
                    fclose($resource);

                    $vars['exito'] = true;
                } else {
                    $vars['exito'] = false;
                    $vars['errors'] = 'El municipio, sexo y periodo establecidos ya existe en el registro';
                }
            }
        }

        $this->view->showViews(array('templates/header.view.php', 'addCsv.view.php', 'templates/footer.view.php'), $vars);
    }

    private function checkDatoRepetido($poblacion): bool
    {
        $nombre = filter_var($poblacion['nombre'], FILTER_SANITIZE_STRING);
        $periodo = filter_var($poblacion['periodo'], FILTER_VALIDATE_INT);
        $sexo = filter_var($poblacion['sexo'], FILTER_SANITIZE_STRING);

        $noExiste = true;

        for ($i = 0; $i < count($poblacion); $i++) {
            for ($j = 0; $j < count($poblacion[$i]); $j++) {
                if (($nombre | $periodo | $sexo) === $poblacion[$i][$j]) {
                    $noExiste = false;
                }
            }
        }
        return $noExiste;
    }

    private function checkDatosMunicipio($poblacion): array
    {
        $errors = [];

        $tipos = ['-', 'Hombre', 'Mujer', 'Total'];

        //Comprobamos el nombre del municipio
        $nombre = filter_var($poblacion['nombre'], FILTER_SANITIZE_STRING);
        if (mb_strlen($nombre) < 1) {
            $errors['nombre'] = 'El nombre del municipio debe tener al menos 1 caracter';
        } elseif (preg_match('/[\P]/u', $nombre)) {
            $errors['nombre'] = 'El nombre del municio solo puede contener letras y espacios';
        }

        //comprobamos el periodo del municipio
        $periodo = filter_var($poblacion['periodo'], FILTER_VALIDATE_INT);
        if (!is_numeric($periodo)) {
            $errors['periodo'] = 'El periodo debe ser un número ';
        } elseif (mb_strlen($nombre) === 4) {
            $errors['periodo'] = 'El periodo debe tener al menos 4 dígitos';
        }

        //comprobamos el sexo
        $sexo = filter_var($poblacion['sexo'], FILTER_SANITIZE_STRING);
        if (!in_array($sexo, $tipos)) {
            $errors['sexo'] = "El sexo debe ser '-', 'Hombre', 'Mujer' o 'Total'";
        }

        //comprobamos el número de la población
        $ponlacion = filter_var($poblacion['total'], FILTER_VALIDATE_INT);
        if (!is_numeric($periodo)) {
            $errors['periodo'] = 'El periodo debe ser un número ';
        }

        return $errors;
    }
}
