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

class Mensaje implements \JsonSerializable{
    private $type;
    private $title;
    private $text;
    private static $ALLOWED_TYPES = ['success', 'warning', 'info', 'danger'];
    private static $ICONS = [
        'success' => 'fas fa-check', 
        'warning' => 'fas fa-exclamation-triangle', 
        'info'   => 'fas fa-info',
        'danger' => 'fas fa-ban'
    ];
    
    public function __construct(string $type, string $title, string $text){
        self::checkType($type);
        $this->text = $text;
        $this->title = $title;
        $this->type = $type;
    }
    
    private static function checkType(string $s){
        if(in_array($s, self::$ALLOWED_TYPES) === false){
            throw new ArgumentoNoValidoException("Tipo de mensaje no válido");
        }
    }
    
    public function getIcon(){
        return self::$ICONS[$this->type];
    }
    
    public function getType() {
        return $this->type;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getText() {
        return $this->text;
    }
    
    public function jsonSerialize() {
        return [
            'type' => $this->type,
            'title' => htmlentities($this->title),
            'text' => htmlentities($this->text)
        ];
    }

}