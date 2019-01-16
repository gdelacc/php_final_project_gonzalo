<?php
namespace App\Utils;

use \PDO;
use \PDOStatement;
use \Exception;

class Sql
{
    /**
     * @var PDO
     */
    private $handle;

    /**
     * Sql constructor.
     * @param string $host
     * @param string $db
     * @param string $user
     * @param string $pass
     */
    public function __construct($host, $db, $user, $pass)
    {
        $connStr = "mysql:host={$host};dbname={$db}";
        $this->handle = new PDO($connStr, $user, $pass);
        $this->handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct()
    {
        $this->handle = null;
    }

    /**
     * @param string $query
     * @param string[] $parameters
     * @return PDOStatement
     */
    private function execQuery($query, $parameters = array())
    {
        $result = $this->handle->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result->execute($parameters);
        return $result;
    }

    public function execOne($query, $parameters = array())
    {
        return $this->execQuery($query, $parameters)->fetch(PDO::FETCH_ASSOC);
    }

    public function execMany($query, $parameters = array())
    {
        return $this->execQuery($query, $parameters)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execNonSelect($query, $parameters = array())
    {
        return $this->execQuery($query, $parameters)->rowCount();
    }

    public function getInsertId()
    {
        return $this->handle->lastInsertId();
    }

    public function checkId($table, $keyfield, $idvalue) {
        $query="SELECT * FROM {$table} WHERE {$keyfield} = :keyValue";
        $params=array(":keyValue"=>$idvalue);
        $row = $this->execOne($query, $params);
        if ($row===false){
            throw new Exception("NO DATA FOUND IN {$table} FOR {$idvalue}");
        }
    }
}