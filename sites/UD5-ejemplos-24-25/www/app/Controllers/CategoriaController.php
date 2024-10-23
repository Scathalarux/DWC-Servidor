<?php
declare(strict_types = 1);
/* 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

namespace Com\Daw2\Controllers;

use \Com\Daw2\Helpers\Mensaje;
/**
 * Description of TestController
 *
 * @author rafa
 */
class CategoriaController extends \Com\Daw2\Core\BaseController{
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * Sin emulado obtenemos que los números se reciben como float
     */
    public function index()
    {             
        $msg = null;
        if(isset($_GET['msg'])){
            $decoded = base64_decode($_GET['msg']);
            $msgArray = json_decode($decoded , true);
            if(json_last_error() === JSON_ERROR_NONE){
                $msg = new Mensaje($msgArray['type'], $msgArray['title'], $msgArray['text']);
            }
        }
        $_vars = array('titulo' => 'Categorías',
                      'breadcumb' => array(
                        'Inicio' => array('url' => '#', 'active' => false),
                        'Categorias (Object)' => array('url' => '#','active' => true)),
                       'msg' => $msg,
                      'Título' => 'Categorías',
                      'js' => array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'assets/js/pages/categoria.index.js')
            );
        $model =  new \Com\Daw2\Models\CategoriaModel();      
        $_vars["data"] = $model->getAllCategorias();
        $this->view->showViews(array('templates/header.view.php', 'categoria.index.php', 'templates/footer.view.php'), $_vars);      
    }            
    
    public function insertCategoriaObject(){
        if(isset($_GET['id_padre'])){
            $idPadre = filter_var($_GET['id_padre'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if(!is_null($idPadre) && $idPadre <= 0){
                $idPadre = NULL;
            }               
        }
        else{
            $idPadre = NULL;
        }
        if(!isset($_GET['nombre']) ||empty($_GET['nombre'])){            
            throw new \Exception("Se debe insertar el nombre de la categoría");
        }        
        else{
            $_vars = array('titulo' => 'Insertar categoría Object');
            $nombre = filter_var($_GET['nombre'], FILTER_SANITIZE_STRING);
            $_vars['nombre'] = $nombre;
            
            $model = new \Com\Daw2\Models\CategoriaModel();
            $categoria = new \Com\Daw2\Helpers\Categoria(NULL, is_null($idPadre) ? NULL : $model->loadCategoria($idPadre), $nombre);
                        
            $_vars['categoria'] = $model->insertCategoriaObject($categoria);            
            
            $this->view->showViews(array('templates/header.view.php', 'categoria.insert.view.php', 'templates/footer.view.php'), $_vars);
        }        
        
    }
    
    public function newShowForm(){  
        $model = new \Com\Daw2\Models\CategoriaModel();
        $categoria = \Com\Daw2\Helpers\Categoria::getStdClass();
        $categoriasList = $model->getAllCategorias();
        //var_dump($categoriasList);
        $_vars = array(
            'titulo' => 'Alta categoría (Object)', 
            'categoria' => $categoria,
            'categoriaEdit' => $categoria,
            'action' => 'new',
            'idPadre' => !is_null($categoria->padre) ? $categoria->padre->id : NULL,
            'categoriasList' => $categoriasList,
            'breadcumb' => array(
                'Inicio' => array('url' => '#', 'active' => false),
                'Categoria' => array('url' => '?controller=categoria','active' => false),
                'Nueva' => array('url' => '#', 'active' => true))
            );
        $this->view->showViews(array('templates/header.view.php', 'categoria.edit.view.php', 'templates/footer.view.php'), $_vars);
    }
    
    public function newProcessForm(){
        $model = new \Com\Daw2\Models\CategoriaModel();
        $_errors = $this->checkForm($_POST, false);
            
        if(count($_errors) === 0){
            $padre = ($_POST['id_padre'] > 0) ? $model->loadCategoria((int)$_POST['id_padre']) : NULL;
            $categoria = new \Com\Daw2\Helpers\Categoria(NULL, $padre, filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS));
            $categoria = $model->insertCategoriaObject($categoria); 
            $mensaje = new \Com\Daw2\Helpers\Mensaje("success", "¡Categoría insertada!", "La categoría " . $categoria->getFullName() . " se ha insertado con éxito"); 
            header('location: /categoria?msg='. base64_encode(json_encode($mensaje)));
            die;
        }
        else{                                
            $std = $this->sanitizeForm($_POST);
            $categoriasList = $model->getAllCategorias();
            //var_dump($categoriasList);
            $_vars = array(
                'titulo' => 'Alta categoría (Object)' , 
                'categoria' => $std,
                'categoriaEdit' => $std,
                'action' => 'new',
                'errors' => $_errors,
                'idPadre' => isset($std->id_padre) ? $std->id_padre : NULL,
                'categoriasList' => $categoriasList,
                'breadcumb' => array(
                    'Inicio' => array('url' => '#', 'active' => false),
                    'Categoria' => array('url' => '?controller=categoria','active' => false),
                    'Nueva' => array('url' => '#', 'active' => true))
                );

            $this->view->showViews(array('templates/header.view.php', 'categoria.edit.view.php', 'templates/footer.view.php'), $_vars);
        }
    }
    
    public function editShowForm(int $idCategoria){        
        $model = new \Com\Daw2\Models\CategoriaModel();        
        $categoria = $model->loadCategoria($idCategoria);
        if(!is_null($categoria)){
            $categoriasList = $model->getAllCategorias();
            //var_dump($categoriasList);
            $_vars = array(
                'titulo' => 'Editar categoría (Object): '.htmlentities($categoria->getFullName()) , 
                'categoria' => $categoria,
                'action' => 'edit',
                'categoriaEdit' => $categoria,
                'idPadre' => !is_null($categoria->padre) ? $categoria->padre->id : NULL,
                'categoriasList' => $categoriasList,                    
                'breadcumb' => array(
                    'Inicio' => array('url' => '#', 'active' => false),
                    'Categoria' => array('url' => '?controller=categoria','active' => false),
                    'Editar' => array('url' => '#', 'active' => true)),                    
                );
            $this->view->showViews(array('templates/header.view.php', 'categoria.edit.view.php', 'templates/footer.view.php'), $_vars);           
        }
        else{
            $errorController = new \Com\Daw2\Controllers\ErrorController();
            $errorController->error404();
        }
    }
    
    public function editProcessForm(){
        $model = new \Com\Daw2\Models\CategoriaModel();
        $_errors = $this->checkForm($_POST);

        if(count($_errors) === 0){
            $padre = ($_POST['id_padre'] > 0) ? $model->loadCategoria((int)$_POST['id_padre']) : NULL;
            $categoria = new \Com\Daw2\Helpers\Categoria((int)$_POST['id_categoria'], $padre, filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS));
            $model->updateCategoriaObject($categoria);                 

            $mensaje = new Mensaje('success', 'Editada correctamente', 'Categoría: '.$categoria->getFullName().' editada correctamente'); 
            header('location: /categoria?msg='. base64_encode(json_encode($mensaje)));
        }
        else{            
            $model = new \Com\Daw2\Models\CategoriaModel();
            $categoria = $model->loadCategoria($_POST['id_categoria']);
            $std = $this->sanitizeForm($_POST);
            $categoriasList = $model->getAllCategorias();
            //var_dump($categoriasList);
            $_vars = array(
                'titulo' => 'Editar categoría (Object): '.htmlentities($categoria->getFullName()) , 
                'categoria' => $categoria,
                'action' => 'edit',
                'categoriaEdit' => $std,
                'errors' => $_errors,
                'idPadre' => isset($std->id_padre) ? $std->id_padre : NULL,
                'categoriasList' => $categoriasList,
                'breadcumb' => array(
                    'Inicio' => array('url' => '#', 'active' => false),
                    'Categoria' => array('url' => '?controller=categoria','active' => false),
                    'Editar' => array('url' => '#', 'active' => true))
                );

            $this->view->showViews(array('templates/header.view.php', 'categoria.edit.view.php', 'templates/footer.view.php'), $_vars);            
        }
    }
    
    public function delete(int $id) : void{
        $model = new \Com\Daw2\Models\CategoriaModel();   
        $mensaje = null;
        try{
            if($model->deleteCategoria($id)){
                $mensaje = new Mensaje("success", "¡Eliminada!", "Categoría borrada con éxito");                
            }
            else{
                $mensaje = new Mensaje("warning", "Sin cambios", "No se ha borrado la categoría: $id");
            }            
        }
        catch(\PDOException $ex){
            if(strpos($ex->getMessage(), '1451') !== false){
                $mensaje = new Mensaje("danger", "No permitido", "Antes de borrar una categoría debe editar o borrar todas las categorías hijas.");
            }
            else{
                $mensaje = new Mensaje("danger", "No permitido", "PDOException: ".$ex->getMessage());
            }
        }        
        finally{
            var_dump($mensaje);
            header('location: /categoria?msg='. base64_encode(json_encode($mensaje)));
        }
    }
    
    private function checkForm(array $_data, bool $isEditing = true) : array{
        $model = new \Com\Daw2\Models\CategoriaModel();
        $_errors = [];
        $idPadre = filter_var($_data['id_padre'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(is_null($idPadre)){
            $_errors['id_padre'] = 'Ha insertado un valor inválido como categoría padre.';
        }
        else{
            if($idPadre > 0){
                $categoriaPadre = $model->loadCategoria($idPadre);
                if(is_null($categoriaPadre)){
                    $_errors['id_padre'] = 'El padre seleccionado no existe.';
                }
            }
        }
        if(empty(trim($_data['nombre']))){
            $_errors['nombre'] = 'Inserte un nombre de categoría';
        }
        else if(!preg_match('/^[a-zA-Z\s]$/', $_data['nombre'])){
            $_errors['nombre'] = 'Sólo se permiten letras, números y espacios';
        }
        $idCategoria = filter_var($_data['id_categoria'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if($isEditing){
            if(is_null($idCategoria)){
                $_errors['name'] = "Error en la petición, inténtelo de nuevo";
            }
            else{
                $categoria = $model->loadCategoria($idCategoria);
                if(is_null($categoria)){
                    $_errors['name'] = "Error en la petición, la categoría no existe";
                }
            }
            if($idPadre === $idCategoria){
                $_errors['id_padre'] = 'La categoría no puede ser padre de si misma.';
            }
        }    
        return $_errors;
    }
    
    private function sanitizeForm(array $_data) : \stdClass{
        $element = new \stdClass();
        foreach($_data as $key => $value){
            $element->$key = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $element->id = $element->id_categoria;
        return $element;
    }
}
