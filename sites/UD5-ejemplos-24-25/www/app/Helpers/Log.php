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

namespace Com\Daw2\Helpers;
/*
 * IES Pazo da MercÃ©
 * Desenvolvemento Web Contorno Servidor
 */

/**
 * Description of Categoria
 *
 * @author profesor
 */
class Log {
    private $id;
    private $operacion;
    private $tabla;
    private $detalle;
    
    private static $_OPERACION = array('insert', 'update', 'delete');
    private static $_TABLA = array('categoria', 'usuario');
    
    public function __construct(?int $id, string $operacion, string $tabla, string $detalle){
        self::checkId($id);
        self::checkOperacion($operacion);
        self::checkTabla($tabla);
        $this->id = $id;
        $this->operacion = $operacion;
        $this->tabla = $tabla;
        $this->detalle = $detalle;
    }
    
    private static function checkId(?int $id){
        if(!is_null($id)){
            if($id <= 0){
                throw new ArgumentoNoValidoException("El identificador debe tener valor NULL o mayor que cero");
            }
        }
    }
    
    private static function checkOperacion(string $operacion){
        if(!in_array($operacion, self::$_OPERACION)){            
            throw new ArgumentoNoValidoException("No se permite la operacion: $operacion");
        }
    }
    
    
    private static function checkTabla(string $tabla){
        if(!in_array($tabla, self::$_TABLA)){            
            throw new ArgumentoNoValidoException("No se permite la tabla: $tabla");
        }
    }
    
    public function getOperacion() {
        return $this->operacion;
    }

    public function getTabla() {
        return $this->tabla;
    }

    public function getDetalle() {
        return $this->detalle;
    }


        
}