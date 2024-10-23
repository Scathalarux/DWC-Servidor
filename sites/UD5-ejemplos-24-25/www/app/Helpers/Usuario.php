<?php
namespace Com\Daw2\Helpers;
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

/**
 * Clase Data Object para almacenar/recuperar los datos de la tablausuario
 *
 * @author Rafael González Centeno
 */
class Usuario {
    private $username;
    private $rol;
    //Tener en cuenta que si se almacenan como decimal en la BBDD volverán como strings
    private $salarioBruto;
    private $retencionIRPF;
    
    public function __construct(){  }        
    
    /*public function __get($key){
        if(isset($this->values[ $key ])){
            return $this->values[ $key ];
        }
        else{
            throw new \Exception("Propiedad no válida");
        }
    }*/
    
    public function getSalarioNeto(){
        return $this->salarioBruto * ( 1 - $this->retencionIRPF / 100);
    }
}
