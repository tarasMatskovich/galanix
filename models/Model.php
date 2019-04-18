<?php


namespace App\Models;

use App\Components\DB;


abstract class Model
{
    protected static $connection = null;
    protected static $table = null;
    protected $attributes = [];
    protected static $params = [];
    protected static $orders = [];

    public static function setConnection() {
        static::$connection = DB::getConnection();
    }

    public static function getTable()
    {
        return static::$table;
    }

    public function __get($property)
    {
        return (isset($this->attributes[$property])) ? $this->attributes[$property] : null;
    }

    public function __set($key, $value)
    {
        $value = htmlspecialchars(addslashes(trim($value)));
        $this->attributes[$key] = $value;
    }

    public static function find($id)
    {
        static::setConnection();
        $id = (int)htmlspecialchars(addslashes(trim($id)));
        $result = static::$connection->query("SELECT * FROM " . static::$table . " WHERE id = " . $id);
        $row = $result->fetch();
        if (!$row)
            return null;
        $activeRecord = new static;
        foreach ($row as $key => $value) {
            $activeRecord->$key = $value;
        }
        return $activeRecord;
    }

    public static function where(array $params)
    {
        static::$params = $params;
        return static::class;
    }

    public static function orderBy(array $params) {
        static::$orders = $params;
        return static::class;
    }

    protected static function createOrderQuery()
    {
        $orders = static::$orders;
        $order = "";
        if (!empty($orders)) {
            foreach ($orders as $key => $value) {
                $order = " ORDER BY " . $key . " " . $value;
            }
        }
        return $order;
    }

    protected static function createWhereQuery()
    {
        $params = static::$params;
        $where = "";
        if (!empty($params)) {
            $where = " WHERE ";
            foreach ($params as $field => $value) {
                $where .= "`" . $field . "` " . $value['operator'] . " " . ":" . $field .  ' AND ';
            }
            $where = substr($where, 0, -5);
        }
        return $where;
    }

    public static function get()
    {
        static::setConnection();
        $where = static::createWhereQuery();
        $order = static::createOrderQuery();
        $sql = "SELECT * FROM " . static::$table . $where . $order;
        $stmt = static::$connection->prepare($sql);
        foreach (static::$params as $field => $value) {
            $stmt->bindParam(":" . $field, $value);
        }
        $assocs = [];
        foreach (static::$params as $field => $value) {
            $assocs[$field] = $value['value'];
        }
        $stmt->execute($assocs);
        $collection = array();
        while ($row = $stmt->fetch()) {
            $activeRecord = new static;
            foreach ($row as $key => $value) {
                $activeRecord->$key = $value;
            }
            $collection[] = $activeRecord;
        }
        static::$params = [];
        static::$orders = [];
        return $collection;
    }



    public function save()
    {
        static::setConnection();
        $fields = "(";
        $values = "(";
        if (empty($this->attributes))
            throw new \Exception("Error: Model - " . static::class . " does not any attribute");
        foreach ($this->attributes as $field => $value) {
            $fields .= $field  . ",";
            $values .= ":" . $field . ",";
        }
        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);
        $fields .= ")";
        $values .= ")";
        $sql = "INSERT INTO " . static::$table . $fields . " VALUES " . $values;
        $stmt  = static::$connection->prepare($sql);
        $result = $stmt->execute($this->attributes);
        if ($result) {
            $this->id = static::$connection->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        static::setConnection();
        $values = '';
        foreach ($this->attributes as $field => $value) {
            $values .= $field . " = :" . $field . ",";
        }
        $values = substr($values, 0, -1);
        $sql = "UPDATE " . static::$table . " SET " . $values . " WHERE id = " . $this->id;
        $stmt  = static::$connection->prepare($sql);
        return $stmt->execute($this->attributes);
    }
}