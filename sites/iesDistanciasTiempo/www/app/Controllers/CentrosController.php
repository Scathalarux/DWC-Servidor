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
            $res = $client->request('GET', "https://api.open-meteo.com/v1/forecast?latitude=" . $centro['latitud'] . "&longitude=" . $centro['longitud'] . "&current=temperature_2m,is_day,weather_code");
            $respuesta = json_decode($res->getBody()->getContents(), true);
            $centro['weather']['temperatura'] = $respuesta['current']['temperature_2m']. ' '. $respuesta['current_units']['temperature_2m'];

            if (strlen((string)$respuesta['current']['weather_code']) == 1) {
                $respuesta['current']['weather_code'] = '0' . $respuesta['current']['weather_code'];
            }

            $centro['weather']['img'] = 'http://openweathermap.org/img/wn/' . $respuesta['current']['weather_code'] . ($respuesta['current']['is_day'] ? 'd' : 'n') . '.png';
            $centrosWeather[] = $centro;
        }
        return $centrosWeather;
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

}