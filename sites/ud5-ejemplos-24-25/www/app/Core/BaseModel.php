<?php
declare(strict_types=1);

namespace Com\Daw2\Core;

abstract class BaseModel {
    protected \PDO $pdo;

    function __construct() {
        $this->pdo = DBManager::getInstance()->getConnection();      
    }
}
