<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class RolModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `rol` ORDER BY rol");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRol(string $type): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `rol` WHERE rol LIKE :type");
        $stmt->execute([':type' => "%$type%"]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find(int $idRol): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `rol` WHERE `id_rol` = ?");
        $stmt->execute([$idRol]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    //AÑADIMOS AQUÍ LAS CONSULTAS A REL_ROL_PERMISOS
    //Ya que si no hubiese roles no habría que crear la tabla con su relación con los permisos
    public function getPermisos(int $id_rol): array
    {
        $sql = 'SELECT * FROM `rel_rol_permiso` WHERE `id_rol` = :id_rol';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_rol' => $id_rol]);
        $bdPermisos = $stmt->fetchAll();

        //establecemos la base de los permisos
        $permisos = [
            'csvController' => '',
            'preferenciasUsuario' => '',
            'usuariosController' => '',
            'userController' => '',
            'usuariosSistemaController' => '',
            'inicioController' => ''
        ];
        foreach ($bdPermisos as $permiso) {
            $controller = $permiso['controller'];
            $permisos = $permiso['permisos'];
            $permisosFinal[$controller] = $permisos;
        }


        //alternativa para trabajar con la clase permisos
        /*$permisos = [
            'csvController' => new Permisos(''),
            'preferenciasUsuario' => new Permisos(''),
            'usuariosController' => new Permisos(''),
            'userController' => new Permisos(''),
            'usuariosSistemaController' => new Permisos(''),
            'inicioController' => new Permisos('')
        ];
        foreach ($bdPermisos as $permiso) {
            $controller = $permiso['controller'];
            $permisos = new Permisos($permiso['permisos']);
            $permisosFinal[$controller] = $permisos;

        }*/

        return $permisosFinal;
    }
}
