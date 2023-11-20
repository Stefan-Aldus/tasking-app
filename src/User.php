<?php

namespace TaskingApp;

class User
{
    private string $username;
    private string $firstName;
    private string $lastName;
    private array $tasks = [];

    public function __construct(string $username, string $firstname, string $lastname)
    {
        $this->username = $username;
        $this->firstName = $firstname;
        $this->lastName = $lastname;
    }

    public static function login(string $username, string $password): null|User
    {
        // Sets the columns to be selected where the username matches the input
        $columns = [
            "user" => [
                "*", // SELECT user.*
            ]
        ];

        $params = ["username" => $username];
        $result = Db::$db->select($columns, $params);
        // If the result is not empty, the user exists and data can be retrieved
        if (!empty($result)) {
            // Check if the password matches the hashed password in the database
            if (password_verify($password, $result[0]["password"])) {
                //  Return a new User object with the retrieved data
                return new User($result[0]["username"], $result[0]["firstname"], $result[0]["lastname"]);
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
        // Check if passwords match
        if ($password1 == $password2) {
            // Create an array with the user details
            $details = [
                "username" => $username,
                "password" => $password1,
                "firstname" => $firstname,
                "lastname" => $lastname
            ];
            // Sanitize user input before executing a query
            InputSanitizer::sanitize($details);
            // Hash the password
            $password = password_hash($password1, PASSWORD_BCRYPT);
            // Insert the user into the database
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

    public static function checkUserAvailable(string $username): bool
    {
        $available = false;
        // Sets the columns to be selected where the username matches the input
        $columns = [
            "user" => [
                "username"
            ]
        ];
        $params = [
            "username" => $username
        ];
        $result = Db::$db->select($columns, $params);
        // If the result is empty, the username is available
        if (empty($result)) {
            $available = true;
        }
        return $available;
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