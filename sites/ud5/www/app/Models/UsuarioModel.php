<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use Decimal\Decimal;
use PDO;
use PDOException;

class UsuarioModel extends BaseDbModel
{
    private const BASE_QUERY = "SELECT u.* , ar.nombre_rol, ac.country_name
                                    FROM usuario u 
                                    JOIN aux_rol ar on u.id_rol = ar.id_rol 
                                    LEFT JOIN aux_countries ac on u.id_country = ac.id";

    private const BASE_COUNT_PAGES = "SELECT COUNT(*) 
                                    FROM usuario u
                                    JOIN aux_rol ar on u.id_rol = ar.id_rol 
                                    LEFT JOIN aux_countries ac on u.id_country = ac.id";

    public const ORDER_COLUMNS = ['username', 'salarioBruto', 'retencionIRPF', 'nombre_rol', 'country_name'];
    public const ORDER_DEFAULT = 1;

    /*//Ya no lo necesitaríamos al extender el BaseDbModel
     * public function __construct()
    {
        //Creamos las variables
        $host = $_ENV['db.host'];
        $db = $_ENV['db.schema'];
        $user = $_ENV['db.user'];
        $pass = $_ENV['db.pass'];
        $charset = $_ENV['db.charset'];
        $emulated = $_ENV['db.emulated'];

        //Creamos el DSN
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        //Creamos las opciones
        $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => $emulated
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }*/
    /**
     * Función que devuelve el conjunto de usuarios
     * @return array conjunto de usuarios
     */
    public function getAllUsuarios(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que devuelve el conjunto de usuarios ordenados de forma descendente según salario
     * @return array conjunto de usuarios ordenados
     */
    public function getUsuariosSalario(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY . " ORDER BY u.salarioBruto DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que devuelve el conjunto de usuarios que son de tipo 'standard'
     * @return array conjunto de usuarios tipo 'standard'
     */
    public function getUsuariosStandard(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY . " WHERE ar.nombre_rol LIKE 'standard'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que devuelve el conjunto de usuarios que contienen en el username 'carlos'
     * @return array conjunto de ususarios
     */
    public function getUsuariosCarlos(): array
    {
        $stmt = $this->pdo->query(self::BASE_QUERY . " WHERE u.username LIKE 'Carlos%'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que devuelve el conjunto de usuarios tras filtrarlos por username
     * @param string $username nombre que se usa como filtro
     * @return array conjunto de usuarios que contiene el nombre en el username
     */
    public function getUsuariosByUsername(string $username): array
    {
        $stmt = $this->pdo->prepare(self::BASE_QUERY . " WHERE u.username LIKE :username");
        $stmt->execute(['username' => "%$username%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que devuelve el conjunto de usuarios tras filtrarlos por su rol
     * @param int $rol rol que tiene asociado el usuario
     * @return array conjunto de usuarios del rol indicado
     */
    public function getUsuariosByRol(int $rol): array
    {
        $stmt = $this->pdo->prepare(self::BASE_QUERY . " WHERE u.id_rol = :id_rol");
        $stmt->execute(['id_rol' => $rol]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que devuelve el conjunto de usuarios tras filtrarlos por salario mínimo y/o máximo
     * @param Decimal|null $salarioMinimo salario mínimo
     * @param Decimal|null $salarioMaximo salario maximo
     * @return array conjunto de usuarios que tienen un salario dentro de lo indicado
     */
    public function getUsuariosBySalario(?Decimal $salarioMinimo, ?Decimal $salarioMaximo): array
    {
        //Condiciones a aplicar en la sentencia
        $condiciones = [];
        //variables para pasar al prepared statement
        $vars = [];

        //Comprobamos qué datos nos pasan y vamos añadiendo condiciones y variables según lo introducido
        if (!is_null($salarioMinimo)) {
            $condiciones[] = "u.salarioBruto >= :salarioMinimo";
            $vars['salarioMinimo'] = $salarioMinimo;
        }
        if (!is_null($salarioMaximo)) {
            $condiciones[] = "u.salarioBruto <= :salarioMaximo";
            $vars['salarioMaximo'] = $salarioMaximo;
        }
        //Si se han introducido condiciones o no, ejecutamos la sentencia pertinente
        if (!empty($condiciones)) {
            $sql = self::BASE_QUERY . " WHERE " . implode(" AND ", $condiciones);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($vars);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $this->getAllUsuarios();
        }
    }

    /**
     * Función que devuelve el conjunto de usuarios tras filtrarlos por retención de IRPF
     *  mínima y/o máxima
     * @param int|null $cotizacionMinima cotización mínima
     * @param int|null $cotizaciónMaxima cotización máxima
     * @return array conjunto de usuarios que tienen una retención dentro de los valores indicados
     */
    public function getUsuariosByCotizacion(?int $cotizacionMinima, ?int $cotizacionMaxima): array
    {
        //Condiciones a aplicar en la sentencia
        $condiciones = [];
        //variables para pasar al prepared statement
        $vars = [];

        //Comprobamos qué datos nos pasan y vamos añadiendo condiciones y variables según lo introducido
        if (!is_null($cotizacionMinima)) {
            $condiciones[] = "u.retencionIRPF >= :cotizacionMinimo";
            $vars['cotizacionMinimo'] = $cotizacionMinima;
        }
        if (!is_null($cotizacionMaxima)) {
            $condiciones[] = "u.retencionIRPF <= :cotizacionMaximo";
            $vars['cotizacionMaximo'] = $cotizacionMaxima;
        }
        //Si se han introducido condiciones o no, ejecutamos la sentencia pertinente
        if (!empty($condiciones)) {
            $sql = self::BASE_QUERY . " WHERE " . implode(" AND ", $condiciones);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($vars);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $this->getAllUsuarios();
        }
    }

    /**
     * Función que devuelve el conjunto de usuarios tras filtrarlos por paises
     * @param array $id_paises conjunto de id de los paises por los que se quiere filtrar
     * @return array conjunto de usuarios que tienen como pais alguno de los paises indicados
     */
    public function getUsuariosByPais(array $id_paises): array
    {
        //variables para pasar al prepared statement
        $vars = [];
        $i = 1;
        //nos recorremos el conjunto de id de paises recibidos como parametros y le añadimos un índice
        foreach ($id_paises as $id_pais) {
            $vars[':id_country' . $i] = $id_pais;
            $i++;
        }
        $sql = self::BASE_QUERY . " WHERE id_country IN ( " . implode(',', array_keys($vars)) . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($vars);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que a través de los datos recibidos como parámetros, construye una condiciones y las variables asociadas para la creación de la query
     * @param array $data conjunto de datos a pocesar
     * @return array conjunto de condiciones y variables para la query
     */
    public function getFiltrosQuery(array $data): array
    {
        $condiciones = [];
        $vars = [];

        //comprobamos el usuario
        if (!empty($data['username'])) {
            $condiciones[] = "u.username LIKE :username";
            $username = $data['username'];
            $vars['username'] = "%$username%";
        }
        if (!empty($data['id_rol'])) {
            $condiciones[] = "u.id_rol = :id_rol";
            $vars['id_rol'] = $data['id_rol'];
        }

        //Comprobamos salario minimo
        if (!empty($data['salarioMinimo']) && filter_var($_GET['salarioMinimo'], FILTER_VALIDATE_FLOAT)) {
            $salarioMinimo = new Decimal($data['salarioMinimo']);
            $condiciones[] = "u.salarioBruto >= :salarioMinimo";
            $vars['salarioMinimo'] = $salarioMinimo;
        }

        //comprobamos salario maximo
        if (!empty($data['salarioMaximo']) && filter_var($_GET['salarioMaximo'], FILTER_VALIDATE_FLOAT)) {
            $salarioMaximo = new Decimal($data['salarioMaximo']);
            $condiciones[] = "u.salarioBruto <= :salarioMaximo";
            $vars['salarioMaximo'] = $salarioMaximo;
        }

        //comprobamos cotización minima
        if (!empty($data['cotizacionMinima']) && filter_var($_GET['cotizacionMinima'], FILTER_VALIDATE_FLOAT)) {
            $cotizacionMinima = new Decimal($data['cotizacionMinima']);
            $condiciones[] = "u.retencionIRPF >= :cotizacionMinima";
            $vars['cotizacionMinima'] = $cotizacionMinima;
        }

        //comprobamos cotización maxima
        if (!empty($data['cotizacionMaxima']) && filter_var($_GET['cotizacionMaxima'], FILTER_VALIDATE_FLOAT)) {
            $cotizacionMaxima = new Decimal($data['cotizacionMaxima']);
            $condiciones[] = "u.retencionIRPF <= :cotizacionMaxima";
            $vars['cotizacionMaxima'] = $cotizacionMaxima;
        }

        //Comprobamos el pais
        if (!empty($data['id_country'])) {
            $varsCountry = [];
            $i = 1;
            foreach ((array)$data['id_country'] as $id_pais) {
                $varsCountry[':id_country' . $i] = $id_pais;
                $i++;
            }
            $condiciones[] = "u.id_country IN ( " . implode(',', array_keys($varsCountry)) . ")";
            $vars = array_merge($vars, $varsCountry);
        }

        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;

        return $resultado;
    }

    /**
     * Función que filtra por varios campos y muestra los usuarios correspondientes
     * @param array $data datos a filtrar
     * @return array usuarios obtenidos con los filtros requeridos
     */
    public function getUsuariosFiltered(array $data, int $order): array
    {
        //Obtenemos las condiciones (filtros) y las variables asociadas
        $filtrosQuery = $this->getFiltrosQuery($data);

        //comprobamos si la ordenación es ascendente o descendente
        $sentido = ($order < 0) ? 'DESC' : 'ASC';
        //introducimos un valor correcto para la columna para ordenar
        $order = abs($order);

        //si hay filtros los procesamos
        if (!empty($filtrosQuery['condiciones'])) {
            $query = self::BASE_QUERY . " WHERE " . implode(" AND ", $filtrosQuery['condiciones']) . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . ' ' . $sentido;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($filtrosQuery['vars']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            //si no hay filtros mostramos todos los usuarios
            $stmt = $this->pdo->query(self::BASE_QUERY . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . ' ' . $sentido);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getMaxPages(array $data): int
    {
        //Obtenemos las condiciones (filtros) y las variables asociadas
        $filtrosQuery = $this->getFiltrosQuery($data);

        //calculamos cuantos registros hay
        //si hay filtros los procesamos
        if (!empty($filtrosQuery['condiciones'])) {
            $query = self::BASE_COUNT_PAGES . " WHERE " . implode(" AND ", $filtrosQuery['condiciones']);
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($filtrosQuery['vars']);
            $numFilas = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT(*)'];
        } else {
            //si no hay filtros mostramos todos los usuarios
            $stmt = $this->pdo->query(self::BASE_COUNT_PAGES);
            $numFilas = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT(*)'];
        }
        //dividimos entre 25 (tamaño de cada página) y nos quedamos con el ceil
        $maxPages = (int)ceil($numFilas / 25);

        return $maxPages;
    }

    /**
     * Función que muestra los resultados según los filtros introducidos por cada página
     * @param array $data filtros introducidos por el usuario
     * @return array conjunto de usuarios a mostrar
     */
    public function getUsuersFilteredPage(array $data, int $order, int $sizePage, int $page): array
    {
        //Obtenemos las condiciones (filtros) y las variables asociadas
        $filtrosQuery = $this->getFiltrosQuery($data);

        //comprobamos si la ordenación es ascendente o descendente
        $sentido = ($order < 0) ? 'DESC' : 'ASC';
        //introducimos un valor correcto para la columna para ordenar
        $order = abs($order);

        //si hay filtros los procesamos
        if (!empty($filtrosQuery['condiciones'])) {
            $query = self::BASE_QUERY . " WHERE " . implode(" AND ", $filtrosQuery['condiciones']) . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . ' ' . $sentido . " LIMIT " . ($page - 1) . ',' . $sizePage;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($filtrosQuery['vars']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            //si no hay filtros mostramos todos los usuarios
            $stmt = $this->pdo->query(self::BASE_QUERY . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . ' ' . $sentido . " LIMIT " . ($page - 1) . ',' . $sizePage);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
