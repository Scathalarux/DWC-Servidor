<?php
declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class EjerciciosController extends BaseController
{
    public function showFormularioNombre(): void
    {
        $data = array(
            'titulo' => 'Formulario nombre',
            'breadcrumb' => ['Ejercicios', 'Formulario nombre'],
            'seccion' => '/test'
        );
        $this->view->showViews(array('templates/header.view.php', 'form-nombre.view.php', 'templates/footer.view.php'), $data);
    }

    public function doFormularioNombre(): void
    {
        $data = array(
            'titulo' => 'Formulario nombre',
            'breadcrumb' => ['Ejercicios', 'Formulario nombre'],
            'seccion' => '/test'
        );
        $data['errors'] = $this->checkErrorFormularioNombre($_POST);
        $data['input'] = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        // Es igual a $data['inputs'] = filter_input_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($data['errors'])) {
            $data['nombreAnterior'] = $data['input']['nombre'];
        }

        $this->view->showViews(array('templates/header.view.php', 'form-nombre.view.php', 'templates/footer.view.php'), $data);
    }

    private function checkErrorFormularioNombre(array $data): array
    {
        $errors = array();
        //comprobamos que en alguna parte del string tenga una letra
        if (!preg_match('/[\p{L}]/iu', $data['nombre'])) {
            $errors['nombre'] = 'El nombredebe contener al menos 1 letra';
        }
        return $errors;
    }

    public function showAnagrama(): void
    {
        $data = array(
            'titulo' => 'Formulario anagrama',
            'breadcrumb' => ['Ejercicios', 'Formulario anagrama'],
            'seccion' => '/anagrama'
        );
        $this->view->showViews(
            array('templates/header.view.php', 'form-anagrama.view.php', 'templates/footer.view.php'),
            $data);
    }

    public function doAnagrama(): void
    {
        $data = array(
            'titulo' => 'Ejercicio anagrama',
            'breadcrumb' => ['Ejercicios', 'Formulario anagrama'],
            'seccion' => '/anagrama'
        );
        $data['errors'] = $this->checkErrorAnagrama($_POST);
        $data['input'] = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($data['errors'])) {
            $data['resultadoAnagrama'] = $this->checkAnagrama($data['input']['palabra1'], $data['input']['palabra2']);
        }

        $this->view->showViews(
            array('templates/header.view.php', 'form-anagrama.view.php', 'templates/footer.view.php'),
            $data);

    }

    function checkAnagrama($palabra1, $palabra2): bool
    {
        $palabra1 = mb_str_split($palabra1, 1);
        $palabra2 = mb_str_split($palabra2, 1);

        if (count(array_diff($palabra1, $palabra2)) === 0) {
            return true;
        } else {
            return false;
        }

        /*
         Alternativa del profe:

         $a1 = mb_str_split($palabra1);
         $a2 = mb_str_split($palabra2);
         sort($a1);
         sort($a2);
         return $a1 === $a2;*/
    }

    private function checkErrorAnagrama(array $data): array
    {
        $errors = array();
        //comprobamos que en alguna parte del string tenga una letra
        if (empty($data['palabra1'])) {
            $errors['palabra1'] = 'La primera palabra es obligatoria';
        } else if (!preg_match('/[\p{L}]/iu', $data['palabra1'])) {
            $errors['palabra1'] = 'La primera palabra debe contener al menos 1 letra';
        }
        if (empty($data['palabra2'])) {
            $errors['palabra2'] = 'La segunda palabra es obligatoria';
        } else if (!preg_match('/[\p{L}]/iu', $data['palabra2'])) {
            $errors['palabra2'] = 'La segunda palabra debe contener al menos 1 letra';
        }
        return $errors;
    }

    public function showMismasLetras(): void
    {
        $data = array(
            'titulo' => 'Ejercicio mismas letras',
            'breadcrumb' => ['Ejercicios', 'Ejercicio mismas letras'],
            'seccion' => '/mismasLetras'
        );
        $this->view->showViews(
            array('templates/header.view.php', 'form-mismas-letras.view.php', 'templates/footer.view.php'),
            $data);
    }

    public function doMismasLetras(): void
    {
        $data = array(
            'titulo' => 'Ejercicio mismas letras',
            'breadcrumb' => ['Ejercicios', 'Ejercicio mismas letras'],
            'seccion' => '/mismasLetras'
        );
        $data['errors'] = $this->checkErrorMismasLetras($_POST);
        $data['input'] = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($data['errors'])) {
            $data['resultadoComparacion'] = $this->checkMismasLetras($data['input']['palabra1'], $data['input']['palabra2']);
        }

        $this->view->showViews(
            array('templates/header.view.php', 'form-mismas-letras.view.php', 'templates/footer.view.php'),
            $data);

    }

    private function checkMismasLetras($palabra1, $palabra2): bool
    {
        $palabra1 = array_unique(mb_str_split(preg_replace('/\P{L}/u', '', mb_strtolower($palabra1))));
        $palabra2 = array_unique(mb_str_split(preg_replace('/\P{L}/u', '', mb_strtolower($palabra2))));


        if (count(array_diff($palabra1, $palabra2)) === 0) {
            return true;
        } else {
            return false;
        }
    }

    private function checkErrorMismasLetras(array $data): array
    {
        $errors = array();
        //comprobamos que en alguna parte del string tenga una letra
        if (empty($data['palabra1'])) {
            $errors['palabra1'] = 'La primera palabra es obligatoria';
        } else if (!preg_match('/[\p{L}]/iu', mb_strtolower($data['palabra1']))) {
            $errors['palabra1'] = 'La primera palabra debe contener al menos 1 letra';
        }
        if (empty($data['palabra2'])) {
            $errors['palabra2'] = 'La segunda palabra es obligatoria';
        } else if (!preg_match('/[\p{L}]/iu', mb_strtolower($data['palabra2']))) {
            $errors['palabra2'] = 'La segunda palabra debe contener al menos 1 letra';
        }
        return $errors;
    }
}