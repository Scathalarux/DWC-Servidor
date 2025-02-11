<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class UsuariosModel extends BaseDbModel
{
    private const SELECT_BASE = "SELECT u.username, u.salarioBruto, u.retencionIRPF, IF(u.activo, 'activo', 'de baja') as activo, ar.nombre_rol as rol, ac.country_name as pais";
    private const FROM = ' FROM usuario u
                            JOIN aux_rol ar ON ar.id_rol = u.id_rol
                            JOIN aux_countries ac ON ac.id = u.id_country ';

    public function getAllUsuarios(): array|false
    {
        $sql = 'SELECT * FROM usuario';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredUsuarios(array $data): array|false
    {
        $filtros = $this->filterQuery($data);

        if ($filtros['conditions'] !== []) {

        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE . self::FROM);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterQuery(array $data): array
    {
        $conditions = [];
        $vars = [];

        //username
        if (!empty($data['username'])) {
            $conditions[] = ' username LIKE :username';
            $vars['username'] = '%' . $data['username'] . '%';
        }

        //salarioBruto
        if(!empty($data['salario_min'])){
            $conditions[] = ' salarioBruto >= :salario_min';
            $vars['salario_min'] = $data['salario_min'];
        }
        if(!empty($data['salario_max'])){
            $conditions[] = ' salarioBruto <= :salario_max';
            $vars['salario_max'] = $data['salario_max'];
        }

        //retencionIRPF
        if(!empty($data['retencion_min'])){
            $conditions[] = ' retencionIRPF >= :retencion_min';
            $vars['retencion_min'] = $data['retencion_min'];
        }
        if(!empty($data['retencion_max'])){
            $conditions[] = ' retencionIRPF <= :retencion_max';
            $vars['retencion_max'] = $data['retencion_max'];
        }

        //activo
        if (!empty($data['activo'])) {
            $conditions[] = ' activo = :activo';
            $vars['activo'] = $data['activo'];
        }


        //id_rol
        if (!empty($data['id_rol'])) {
            $conditions[] = ' id_rol = :id_rol';
            $vars['id_rol'] = $data['id_rol'];
        }

        //id_country
        


        return ['conditions' => $conditions, 'vars' => $vars];
    }
}