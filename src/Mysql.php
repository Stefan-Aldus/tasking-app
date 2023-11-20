<?php

namespace TaskingApp;

use PDO;
use PDOException;

class Mysql implements Database
{
    private PDO $connection;

    public function connect(string $server, string $user, string $password, string $database)
    {
        try {
            $this->connection = new PDO("mysql:host=$server;dbname=$database", $user, $password);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage() . "<br/>";
        }
    }

    public function insert(string $table, array $params = [])
    {
        if (!empty($params) && is_array($params)) {
            $columns = implode(', ', array_keys($params));
            $values = ':' . implode(', :', array_keys($params));

            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            $insert = $this->connection->prepare($query);

            foreach ($params as $key => $value) {
                $insert->bindValue(":$key", $value);
            }

            $insert->execute();
        }
//        INSERT INTO user (name, password) VALUES (':username', ':password')";
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function select(array $columns, array $params = [])
    {
        // SELECT user.name, order.date FROM user, order WHERE user.id = order.user_id
        // SELECT user.name FROM user WHERE user.id = 1
        // SELECT user.name FROM user WHERE user.name LIKE '%random%'
        // SELECT order.id FROM order WHERE order.date BETWEEN '2020-01-01' AND '2020-01-31'

        try {
            $query = "SELECT ";
            if (is_array($columns)) {
                $columnNameArray = [];
                foreach ($columns as $tableName => $columnArray) {
                    if (is_array($columnArray)) {
                        foreach ($columnArray as $columnName) {
                            // [ 0 => 'user.id', 1 => 'user.name']
                            $columnNameArray[] = $tableName . "." . $columnName;
                        }
                    }
                }
            }
//            SELECT user.name, user.email, score.highscore
            $query .= implode(", ", $columnNameArray);
//            SELECT user.name, user.email, order.data FROM user, score
            $query .= " FROM " . implode(", ", array_keys($columns));

//            WHERE statement
            if (!empty($params)) {
                $query .= " WHERE ";
                $conditions = [];
                foreach ($params as $key => $value) {
                    $tableAndColumn = explode(".", $key, 2);
                    if (count($tableAndColumn) === 2) {
                        // user.id
                        $table = $tableAndColumn[0];
                        $column = $tableAndColumn[1];
                    } else {
                        // id
                        $table = array_keys($columns)[0];
                        $column = $key;
                    }

                    /* Zo zien de params er uit (voorbeeld)
                    * $params =[
                     * 'user.id' => $variable, string/int
                     * 'score.highscore' => ['500', '1000']
                     * 'user.name' => '%random%'
                     * 'user.score_id' => 'score.id'
                     * ]
                    */

                    if (is_array($value)) {
                        // BETWEEN
                        $conditions[] = "$table.$column BETWEEN '{$value[0]}' AND '{$value[1]}'";
                    } elseif (strpos($key, "LIKE") !== false) {
                        // LIKE
                        $conditions[] = "$table.$column '$value'";
                    } elseif (strpos($value, ".") !== false) {
                        // JOIN
                        $conditions[] = "$table.$column = $value";
                    } else {
                        // Gelijk aan waarde
                        $conditions[] = "$table.$column = '$value'";
                    }
                }
                $query .= implode(" AND ", $conditions);
            }
//            var_dump($query);
//            Resultaat laten zien
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch
        (PDOException $error) {
            echo "Error: " . $error->getMessage() . "<br/>";
        }
    }
}