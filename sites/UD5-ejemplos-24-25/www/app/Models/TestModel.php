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
/**
 * Diferentes test sobre la base de datos
 *
 * @author Rafael González Centeno
 */
class TestModel extends \Com\Daw2\Core\BaseModel{
    
    public function getUsuariosClass(array $options = array()) : array{
        foreach($options as $key => $value){
            $this->pdo->setAttribute($key, $value);
        }
        $query = $this->pdo->query("Select * FROM usuario");        
        $query->setFetchMode(PDO::FETCH_CLASS, '\Com\Daw2\Helpers\Usuario');
        return $query->fetchAll();
    }
    
    /**
     * No da errores porque tenemos emulation mode en off, si lo ponemos en on daría error
     * @param int $from
     * @param int $to
     * @return array
     */
    public function getUsuariosLimit(int $from, int $to) : array{        
        $query = $this->pdo->prepare("Select * FROM usuario LIMIT :from, :to");        
        $query->setFetchMode(PDO::FETCH_CLASS, '\Com\Daw2\Helpers\Usuario');
        $query->execute(['from' => $from, 'to' => $to]);
        return $query->fetchAll();
    }
    
    /**
     * Este método funciona siempre da igual como tengamos el emulation mode
     * @param int $page
     * @param int $entries
     * @return array
     */
    public function getUsuariosLimitBind(int $page, int $entries) : array{   
        $query = $this->pdo->prepare("Select * FROM usuario ORDER BY username LIMIT :page, :entries");        
        $query->setFetchMode(PDO::FETCH_CLASS, '\Com\Daw2\Helpers\Usuario');
        $query->bindValue(':page', (int)$page, PDO::PARAM_INT);
        $query->bindValue(':entries', (int)$entries, PDO::PARAM_INT); 
        $query->execute();
        return $query->fetchAll();
    }
    
    public function getUsuariosByActive(bool $active) : array{   
        $query = $this->pdo->prepare("Select * FROM usuario WHERE activo = :active ORDER BY username");        
        
        $query2 = $this->pdo->prepare("Select * FROM usuario WHERE username LIKE '%:username%'"); /* Erróneo */
        $query2->execute(['username' => 'rafa']);
        
        $query3 = $this->pdo->prepare("Select * FROM usuario WHERE username IN :lista_usuarios"); /* Erróneo */
        $lista = ['Pepito', 'Pedro', 'Manolo'];
        $query3->execute(['lista_usuarios' => implode(",", $lista)]);
        
        $query->setFetchMode(PDO::FETCH_CLASS, '\Com\Daw2\Helpers\Usuario');
        /* Podemos usar bindValue y no poner parámetros en execute o poner directamente los parámetros en execute */
        //$query->bindValue(':active', $active, PDO::PARAM_BOOL);
        $query->execute(['active' => $active]);
        return $query->fetchAll();
    }
    
    public function getUsuarioOrderBy(string $field, $asc = true) : array{
        //Lista blanca
        $_orders = ['username', 'rol'];
        //Comprobamos que el campo que solicita el usuario para ordenar está en la lista blanca
        if(in_array($field, $_orders)){
            $orderBy = $field;
        }
        else{
            $orderBy = 'username';
        }
        $direction = $asc ? 'ASC' : 'DESC';
        //Como hemos filtrado, podemos estar seguros de que no va a hacer nada para lo que no esté autorizado
        
        $query = $this->pdo->prepare("Select * FROM usuario ORDER BY $orderBy $direction"); 
        $query->setFetchMode(PDO::FETCH_CLASS, '\Com\Daw2\Helpers\Usuario');
        $query->execute();
        return $query->fetchAll();
    }
    
    public function rellenarAleatorio() : int{
        $nombre = ["Carlos", "Miguel", "Iván", "Benjamín", "Francisco", "Erik", "Alexis Jose", "Marcos", "Cristopher", "Mauricio", "Jose Simon", "Nuria Maria"];
        $apellido1 = ["Alvarez", "Candeira", "Casas", "Dominguez", "Fernandez", "Ferreira", "Giraldez", "Gonzalez", "Juncal", "Montes", "Sanchez", "da Silva", "Suarez"];
        $apellido2 = ["Sanchez", "Carrera", "Cerqueira", "Fernandez", "Araujo", "Oset", "Groba", "Pereira", "Abeledo", "Iglesias", "Gonzalez", "Vilas"];
        $_roles = ["administrador", "facturas", "gestor", "ventas", "standard"];
        $insertado = 0;
        //Si no estuviera emulated = off el prepare debería ir dentro del for
        $query = $this->pdo->prepare("INSERT INTO usuario (username, rol, salarioBruto, retencionIRPF) values (:username, :rol, :bruto, :irpf)");
        for($i = 0; $i < 100; $i++){            
            $username = $nombre[random_int(0, count($nombre) -1)].'_'.$apellido1[random_int(0, count($apellido1) -1)].'_'.$apellido2[random_int(0, count($apellido2) -1)];
            $username = preg_replace("/[^A-Za-z_]/", "_", $username);
            $rol = $_roles[random_int(0, 4)];
            $salario = random_int(1000, 5000);
            $irpf = self::calcularIRPF($salario);
            try{
                $query->execute(
                        [
                            'username'  => $username,
                            'rol'       => $rol,
                            'bruto'     => $salario,
                            'irpf'      => $irpf
                        ]
                );
                $insertado++;
            }
            catch(\PDOException $ex){
                //Estamos metiendo una entrada duplicada
            }
            
        }
        return $insertado;
    }
    
    private static function calcularIRPF(float $salario){
        if($salario < 3000){
            $irpf = 18;
        }
        elseif($salario < 4000){
            $irpf = 20;
        }
        else{
            $irpf = 30;
        }
        return $irpf;
    }
    
    public function updateSalarUsuario(string $usuario, float $salar) : int{
        $irpf = self::calcularIRPF($salar);
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("UPDATE usuario SET salarioBruto = :salarioBruto, retencionIRPF = :retencionIRPF WHERE username = :username");
            $stmt->execute(['salarioBruto' => $salar, 'retencionIRPF' => $irpf, 'username' => $usuario]);
            $edited = $stmt->rowCount();
            if($edited > 0){
                $log = new \Com\Daw2\Helpers\Log(NULL, 'update', 'usuario', 'Actualizado el sueldo del usuario "'.$usuario.' al valor: '. $salar);     
                $stmtLog = $this->pdo->prepare("INSERT INTO log (operacion, tabla, detalle) VALUES (:operacion, :tabla, :detalle)");
                $stmtLog->execute(['operacion' => $log->getOperacion(), 'tabla' => $log->getTabla(), 'detalle' => $log->getDetalle()]);
            }
            $this->pdo->commit();
        }
        catch(\Exception $ex){
            $this->pdo->rollback();
            throw $ex;
        }
        return $edited;
    }        
    
    public function deleteUsuariosByName(string $username) : int{
        $like = "%$username%";
        $stmt = $this->pdo->prepare("DELETE FROM usuario WHERE username LIKE ?");
        $stmt->execute([$like]);
        return $stmt->rowCount();
    }
    
    public function insertCategoria(string $nombre, ?int $padre) : int{
        $stmt = $this->pdo->prepare("INSERT INTO categoria (nombre_categoria, id_padre) VALUES (:nombre, :id_padre)");
        $stmt->execute(['nombre' => $nombre, 'id_padre' => $padre]);
        //Tras la realización de la inserción, solicitamos el id con el que se creó la categoría
        return $this->pdo->lastInsertId();
    }
        
}
