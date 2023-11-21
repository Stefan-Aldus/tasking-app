<?php

namespace TaskingApp;

class User
{
    private string $username;
    private string $firstName;
    private string $lastName;
    private int $userId;
    private array $tasks = [];

    public function __construct(string $username, string $firstname, string $lastname, int $userId)
    {
        $this->username = $username;
        $this->firstName = $firstname;
        $this->lastName = $lastname;
        $this->userId = $userId;
        $this->getTasksFromDb();
    }

    private function getTasksFromDb(): void
    {
        $columns = [
            "task" => [
                "*"
            ],
            "user" => [
                "id"
            ]
        ];
        $params = [
            "user.id" => "task.user_id",
        ];

        $result = Db::$db->select($columns, $params);
        if (empty($result)) {
            return;
        }
        foreach ($result as $task) {
            if (isset($task["date"])) {
                $task["date"] = date("Y-m-d", strtotime($task["date"]));
            }
            if (!isset($task["description"])) {
                $task["description"] = "No Description Set...";
            }
            $this->tasks[] = new Task($task["id"], $task["name"], $task["description"], $task["date"], $task["completed"]);
        }
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
                return new User($result[0]["username"], $result[0]["firstname"], $result[0]["lastname"], $result[0]["id"]);
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

    public function getTasks(): array
    {
        unset($this->tasks);
        $this->getTasksFromDb();
        return $this->tasks;
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function updateUsername($newUsername): void
    {
        $table = "user";
        $params = [
            "username" => $newUsername
        ];
        $where = [
            "id" => $this->userId
        ];
        Db::$db->update($table, $params, $where);
        $this->username = $newUsername;
    }

    public function updatePassword($newPassword1, $newPassword2, $currentPassword): bool
    {
        $storedPassword = Db::$db->select(["user" => ["password"]], ["id" => $this->userId])[0]["password"];

        if (!password_verify($currentPassword, $storedPassword)) {
            return false;
        }

        if ($newPassword1 != $newPassword2) {
            return false;
        }

        $table = "user";
        $params = [
            "password" => password_hash($newPassword1, PASSWORD_BCRYPT),
            "id" => $this->userId,
        ];
        Db::$db->update($table, $params);

        return true;
    }
}