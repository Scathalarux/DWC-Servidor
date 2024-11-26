<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class PreferenciasUsuario extends BaseController
{
    public function showPreferenciasUsuario(): void
    {
        $data = [
            'titulo' => 'Preferencias Usuario',
            'temas' => ['claro', 'oscuro']
        ];

        $this->view->showViews(array('templates/header.view.php', 'preferenciasUsuario.view.php', 'templates/footer.view.php'), $data);
    }
    public function doPreferenciasUsuario(): void
    {
        $data = [
            'titulo' => 'Preferencias Usuario',
            'temas' => ['claro', 'oscuro']
        ];
/*        if (isset($_POST['theme-button'])) {
            if (!isset($_POST['tema'])) {
                $data['temaElegido'] = $_POST['tema'];
                setcookie("theme", $data['temaElegido'], time() + (86400 * 365));
            }
        }*/
        if (isset($_POST['username-button'])) {
            if (!isset($_POST['username']) && mb_strlen($_POST['username']) > 0 && mb_strlen($_POST['username']) <= 50) {
                $_SESSION['username'] = htmlspecialchars($_POST['username']);
            }
        }

        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        $this->view->showViews(array('templates/header.view.php', 'preferenciasUsuario.view.php', 'templates/footer.view.php'), $data);
    }
}
