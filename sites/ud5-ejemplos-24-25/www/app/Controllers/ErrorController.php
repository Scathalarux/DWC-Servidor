<?php
namespace Com\Daw2\Controllers;

class ErrorController extends \Com\Daw2\Core\BaseController
{
   
   public function error404 ()
   {               
       http_response_code(404);
        $_vars = array('titulo' => 'Página no encontrada',
                      'breadcumb' => array('Inicio' => array('url' => '#', 'active' => false)));
        $this->view->showViews(array('templates/header.view.php', '404.view.php', 'templates/footer.view.php'), $_vars);      
   }
   
}