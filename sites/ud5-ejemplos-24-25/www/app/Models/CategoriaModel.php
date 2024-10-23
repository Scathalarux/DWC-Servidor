<?php

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
namespace Com\Daw2\Models;

use \PDO;
use Com\Daw2\Helpers\Categoria;
/**
 * Diferentes test sobre la base de datos
 *
 * @author Rafael González Centeno
 */
class CategoriaModel extends \Com\Daw2\Core\BaseModel{    
    
    public function insertCategoriaObject(Categoria $c) : ?Categoria{        
        $stmt = $this->pdo->prepare("INSERT INTO categoria (nombre_categoria, id_padre) VALUES (:nombre, :id_padre)");        
        //Si usamos isset va a dar error porque no llama al magic get
        $idPadre = !is_null($c->padre) ? $c->padre->id : null;
        if($stmt->execute(['nombre' => $c->nombre, 'id_padre' => $idPadre])){
            //Tras la realización de la inserción, solicitamos el id con el que se creó la categoría
            return $this->loadCategoria($this->pdo->lastInsertId());
        }
        else{
            return null;
        }
    }
        
    public function updateCategoriaObject(Categoria $c) : ?Categoria{
        $stmt = $this->pdo->prepare("UPDATE categoria SET nombre_categoria = :nombre, id_padre = :id_padre WHERE id_categoria = :id_categoria");
        //Si usamos isset va a dar error porque no llama al magic get
        $idPadre = !is_null($c->padre) ? $c->padre->id : null;
        if($stmt->execute(['nombre' => $c->nombre, 'id_padre' => $idPadre, 'id_categoria' => $c->id])){
            //Tras la realización de la inserción, solicitamos el id con el que se creó la categoría
            return $c;
        }
        else{
            return null;
        }
    }
    
    public function deleteCategoria(int $id) : bool{
        $stmt = $this->pdo->prepare("DELETE FROM categoria WHERE id_categoria = ?");
        if($stmt->execute([$id])){
            return $stmt->rowCount() > 0;
        }
        else{
            return false;
        }
    }
    
    /**
     * Carga una Categoría desde la base de datos
     * @param int $id Identificador de la categoría
     * @return Categoria|null Null si el identificador no existe. La Categoría en caso de existir.
     */
    public function loadCategoria(int $id) : ?Categoria{
        $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
        $stmt->execute([$id]);
        if($row = $stmt->fetch()){
           return $this->rowToCategoria($row);
        }        
        return null;
    }        
    
    /*
     * Obtención de listado con clases
     */
    public function getAllCategorias() : array{
        $_res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id_padre is NULL ORDER BY nombre_categoria");
        $stmt->execute();
        $_categorias = $stmt->fetchAll();
        foreach($_categorias as $c){
            $actual = $this->rowToCategoria($c);
            $_res[] = $actual;            
            $_res = array_merge($_res, $this->getAllCategoriasHijas($actual->id));            
        }
        return $_res;
    }
    private function getAllCategoriasHijas(int $id_padre) : array{
        $_res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id_padre = ? ORDER BY nombre_categoria");
        $stmt->execute([$id_padre]);
        $_cats = $stmt->fetchAll();
        foreach($_cats as $c){
            $actual = $this->rowToCategoria($c);
            $_res[] = $actual;
            $_res = array_merge($_res, $this->getAllCategoriasHijas($actual->id));
        }
        return $_res;
    }
    
    private function rowToCategoria(array $row) : Categoria{
        if (is_null($row['id_padre'])) {
            $categoria = new Categoria($row['id_categoria'], NULL, $row['nombre_categoria']);
        } else {
            $categoria = new Categoria($row['id_categoria'], $this->loadCategoria($row['id_padre']), $row['nombre_categoria']);
        }
        return $categoria;
    }
    
}