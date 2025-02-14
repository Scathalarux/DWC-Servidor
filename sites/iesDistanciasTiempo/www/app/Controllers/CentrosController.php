<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\CentrosModel;
use Com\Daw2\Models\CiclosModel;
use GuzzleHttp\Client;

class CentrosController extends BaseController
{
    private const ALLOWED_PARAMS = ['concello', 'codigo', 'centro_educativo', 'telefono', 'provincia', 'link_fp', 'latitud', 'longitud', 'familia_informatica'];

    private const CHECK_TYPES = ['add' => 'add', 'edit' => 'edit'];
    private const DEFAULT_ORDER = 1;
    private const DEFAULT_PAGE = 1;

    private const DEFAULT_SIZE_PAGE = 20;

    public function listadoConFiltros(): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Listado de Centros',
            'breadcrumb' => ['Inicio', 'Listado de Centros'],
        ];

        $centrosModel = new CentrosModel();

        $copiaGet = $_GET;
        //mantenemos los filtros sin la pagina
        unset($copiaGet['page']);
        $data['copiaGetPage'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetPage'])) {
            $data['copiaGetPage'] .= '&';
        }

        //mentenemos los filtros sin la pagina ni la ordenación
        unset($copiaGet['order']);
        $data['copiaGetOrder'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetOrder'])) {
            $data['copiaGetOrder'] .= '&';
        }


        $order = $this->getOrder();
        $maxPage = $centrosModel->getMaxPage($_GET, self::DEFAULT_SIZE_PAGE);
        $page = $this->getPage($maxPage);

        $centros = $centrosModel->getCentros($_GET, $order, $page, self::DEFAULT_SIZE_PAGE);
        $centros = $this->apiWeather($centros);

        $data['centros'] = $centros;
        $data['order'] = $order;
        $data['maxPage'] = $maxPage;
        $data['page'] = $page;
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $this->view->showViews(array('templates/header.view.php', 'centros.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData(): array
    {
        $data = [];

        $ciclosModel = new CiclosModel();
        $data['ciclos'] = $ciclosModel->getAll();

        return $data;
    }

    public function getOrder(): int
    {
        if (isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(CentrosModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }

        }
        return self::DEFAULT_ORDER;
    }

    public function getPage(int $maxPage): int
    {
        if (isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['page'] > 0 && (int)$_GET['page'] <= $maxPage) {
                return (int)$_GET['page'];
            }

        }
        return self::DEFAULT_PAGE;
    }

    public function apiWeather(array $centros): array
    {
        $centrosWeather = [];
        $client = new Client();
        foreach ($centros as $centro) {
            if (!empty($centro['latitud']) && !empty($centro['longitud'])) {
                $res = $client->request('GET', "https://api.open-meteo.com/v1/forecast?latitude=" . $centro['latitud'] . "&longitude=" . $centro['longitud'] . "&current=temperature_2m,is_day,weather_code");
                $respuesta = json_decode($res->getBody()->getContents(), true);
                var_dump($respuesta);
                $centro['weather']['temperatura'] = $respuesta['current']['temperature_2m'] . ' ' . $respuesta['current_units']['temperature_2m'];
                $centro['weather']['weather_code'] = $respuesta['current']['weather_code'];
                $day = $respuesta['current']['is_day'] ? true : false;
                $centro['weather']['img'] = $this->getWeatherImg($centro['weather']['weather_code'], $day);
            }
            $centrosWeather[] = $centro;
        }

        return $centrosWeather;
    }

    public function getWeatherImg(int $weatherCode, bool $isDay): string
    {
        //TODO terminar obtención imagenes
        $json =
        $weatherIcons = json_decode($json, true);
        $day = $isDay ? 'day' : 'night';
        return $weatherIcons[$weatherCode][$day];
    }

    public function delete(int $codigo): void
    {
        $centrosModel = new CentrosModel();
        $centro = $centrosModel->getCentroByCodigo($codigo);
        if ($centro === false) {
            header('Location: /centros');
        } else {
            $result = $centrosModel->delete($codigo);
            if ($result === false) {
                //mensaje de error
                $mensaje = new Mensaje('No se pudo borrar el centro', Mensaje::ERROR, 'Error');
            } else {
                //mensaje de éxito
                $mensaje = new Mensaje('Centro borrado correctamente', Mensaje::SUCCESS, 'Éxito');
            }
            $this->addFlashMessage($mensaje);
            header('Location: /centros');
        }
    }

    public function showAdd(array $errores = [], array $input = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Añadir centro',
            'breadcrumb' => ['Inicio', 'Centros', 'Añadir centro'],
        ];

        $data['errores'] = $errores;
        $data['input'] = $input;

        $this->view->showViews(array('templates/header.view.php', 'edit.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAdd()
    {
        $errores = $this->checkForm($_POST, self::CHECK_TYPES['add']);
        if ($errores === []) {
            //comprobar que están todos los elementos necesarios para añadir aunque sea a null, y el checkbox de informatica
            $insertData = [];
            foreach (self::ALLOWED_PARAMS as $key) {
                $insertData[$key] = isset($_POST[$key]) ? $insertData[$key] : null;
            }

            $centrosModel = new CentrosModel();

            $centro = $centrosModel->addCentro($insertData);
            if ($centro === false) {
                $mensaje = new Mensaje('No se pudo añadir el centro', Mensaje::ERROR, 'Error');
            } else {
                $mensaje = new Mensaje('Centro añadido correctamente', Mensaje::SUCCESS, 'Éxito');
            }

            $this->addFlashMessage($mensaje);
            header('Location: /centros');

        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showAdd($errores, $input);
        }
    }

    public function checkForm(array $data, string $type): array
    {
        $errores = [];

        //concello
        if (!empty($data['concello'])) {
            if (preg_match('/[\p{L} ]{3,50}/ui', $data['concello'])) {
                $errores['concello'] = 'El concello debe estar compuesto por letras y tener un máximo de 50 caracteres';
            }
        }

        //codigo --> UNICO obligatorio según BBDD
        if (!empty($data['codigo'])) {
            if (filter_var($data['codigo'], FILTER_VALIDATE_INT) === false) {
                $errores['codigo'] = 'El código debe estar compuesto dígitos';
            } elseif (strlen($data['codigo']) !== 8) {
                $errores['codigo'] = 'El código debe estar compuesto por 8 dígitos';
            }
        } elseif ($type === 'add') {
            $errores['codigo'] = 'El codigo de centro es obligatorio';
        }

        //centro
        if (!empty($data['centro'])) {
            if (preg_match('/[\p{L} ]{5,40}/ui', $data['centro'])) {
                $errores['centro'] = 'El centro debe estar compuesto por letras y tener un máximo de 40 caracteres';
            }
        }

        //telefono
        if (!empty($data['telefono'])) {
            if (filter_var($data['telefono'], FILTER_VALIDATE_INT) === false) {
                $errores['telefono'] = 'El teléfono debe estar compuesto dígitos';
            } elseif (strlen($data['telefono']) !== 9) {
                $errores['telefono'] = 'El teléfono debe estar compuesto por 8-12 dígitos';
            }
        }

        //provincia
        if (!empty($data['provincia'])) {
            if (preg_match('/[\p{L} ]{1,10}/ui', $data['provincia'])) {
                $errores['provincia'] = 'La provincia debe estar compuesta por letras y tener un máximo de 10 caracteres';
            }
        }

        //link
        if (!empty($data['link'])) {
            if (preg_match('/[\p{L} ]{10,100}/ui', $data['link'])) {
                $errores['link'] = 'El enlace del centro debe estar compuesto por letras y tener un máximo de 100 caracteres';
            } elseif (filter_var($data['link'], FILTER_VALIDATE_URL) === false) {
                $errores['link'] = 'El enlace del centro debe ser formato URL';
            }
        }

        //latitud
        if (!empty($data['latitud'])) {
            if (filter_var($data['latitud'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['latitud'] = 'La provincia debe estar en formato decimal';
            }

        }

        //longitud
        if (!empty($data['longitud'])) {

            $errores['longitud'] = 'La provincia debe estar compuesta por letras y tener un máximo de 10 caracteres';

        }

        return $errores;
    }

    public function showEditar(int $codigoCentro, array $errores = [], array $input = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Editar centro',
            'breadcrumb' => ['Inicio', 'Centros', 'Editar centro'],
        ];

        $centrosModel = new CentrosModel();

        $data['errores'] = $errores;
        $data['input'] = !empty($input) ? $input : $centrosModel->getCentroByCodigo($codigoCentro);

        $this->view->showViews(array('templates/header.view.php', 'edit.view.php', 'templates/footer.view.php'), $data);
    }

    public function doEditar(int $codigoCentro): void
    {
        //comprobamos que existe el centro que se quiere modificar
        $centrosModel = new CentrosModel();
        $centro = $centrosModel->getCentroByCodigo($codigoCentro);
        if ($centro === false) {
            header('Location: /centros');
        } else {
            //existe el centro
            $errores = $this->checkForm($_POST, self::CHECK_TYPES['edit']);
            if ($errores === []) {
                $insertData = $_POST;
                foreach ($centro as $key) {
                    $insertData[$key] = isset($_POST[$key]) ? $_POST[$key] : $centro[$key];
                }
                $resultado = $centrosModel->editCentro($insertData);
                if ($resultado === false) {
                    $mensaje = new Mensaje('No se pudo editar el centro', Mensaje::ERROR, 'Error');
                } else {
                    $mensaje = new Mensaje('Centro editado correctamente', Mensaje::SUCCESS, 'Éxito');
                }
                $this->addFlashMessage($mensaje);
                header('Location: /centros');
            } else {
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showEditar($codigoCentro, $errores, $input);
            }
        }

    }

    public function showCentro(int $codigoCentro): void
    {
        $centrosModel = new CentrosModel();
        $centro = $centrosModel->getCentroByCodigo($codigoCentro);
        if ($centro === false) {
            header('Location: /centros');
        }else{
            $data['input'] = $centro
            $data['disabled']= true;
            $this->view->showViews(array('templates/header.view.php', 'edit.view.php', 'templates/footer.view.php'), $data);

        }
    }

}