<?php

namespace TaskingApp;

class User
{
    private string $username;
    private string $firstName;
    private string $lastName;
    private string $password;
    private array $tasks = [];

    public function __construct(string $username, string $firstname, string $lastname, string $password)
    {
        $this->username = $username;
        $this->firstName = $firstname;
        $this->lastName = $lastname;
        $this->password = $password;
    }

    public static function login(string $username, string $password): null|User
    {
        $columns = [
            "user" => [
                "*", // SELECT user.*
            ]
        ];

        $params = ["username" => $username];

        $result = Db::$db->select($columns, $params);

        if (!empty($result)) {
            if (password_verify($password, $result[0]["password"])) {
                return new User($result[0]["username"], $result[0]["firstname"], $result[0]["lastname"], $result[0]["password"]);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function register(string $username, string $password1, string $password2, string $firstname, string $lastname): bool
    {
        $success = false;
        if ($password1 == $password2) {
            $password = password_hash($password1, PASSWORD_BCRYPT);
            $table = "user";
            $params = [
                "username" => $username,
                "password" => $password,
                "firstname" => $firstname,
                "lastname" => $lastname
            ];
            Db::$db->insert($table, $params);
            $success = true;
        }

        return $success;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getTasksFromDb()
    {
        $columns = [
            "task" => [
                "*"
            ]
        ];
        $params = [
            "task.user_id" => "user.id",
        ];

        $result = Db::$db->select($columns, $params);
        foreach ($result as $task) {
            if (isset($task["date"])) {
                $task["date"] = date("Y-m-d", strtotime($task["date"]));
            }
            if (!isset($task["description"])) {
                $task["description"] = "";
            }
            $this->tasks[] = new Task($task["id"], $task["name"], $task["description"], $task["date"], $task["isdone"]);
        }
    }
}