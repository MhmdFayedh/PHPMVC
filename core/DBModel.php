<?php 

namespace app\core;


use app\core\Model;
use PDOStatement;

abstract class DBModel extends Model
{
    abstract public static function tableName(): string;
    abstract public function attribute(): array;
    abstract public static function primaryKey(): string; 

    public function save()
    {
        $tableName = $this->tableName();
        $attrbuite = $this->attribute();
        $params = array_map(fn($attr) => ":$attr", $attrbuite);
        $stmt = self::prepare("INSERT INTO $tableName (".implode(',', $attrbuite).") VALUES (".implode(',', $params).")
        ");

        foreach($attrbuite as $attr){
            $stmt->bindValue(":$attr",$this->{$attr});
        }

        $stmt->execute();
        return true;

    }

    


    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare(string $sql):PDOStatement
    {
        return Application::$app->DB->pdo->prepare($sql);
    }
}