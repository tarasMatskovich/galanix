<?php


namespace App\Models;

use App\Components\DB;


abstract class Model
{
    protected static $connection = null;
    protected static $table = null;
    protected $attributes = [];
    protected static $params = [];

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

    public static function get()
    {
        static::setConnection();
        $sql = "SELECT * FROM " . static::$table;
        if (!empty(static::$params)) {
            $sql .= " WHERE ";
            foreach (static::$params as $field => $value) {
                $sql .= $field . "=" . ":" . $field . " AND ";
            }
            $sql = substr($sql, 0, -5);
        }
        $stmt = static::$connection->prepare($sql);
        foreach (static::$params as $field => $value) {
            $stmt->bindParam(":" . $field, $value);
        }
        $stmt->execute();
        $collection = array();
        while ($row = $stmt->fetch()) {
            $activeRecord = new static;
            foreach ($row as $key => $value) {
                $activeRecord->$key = $value;
            }
            $collection[] = $activeRecord;
        }
        static::$params = [];
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