<?php

namespace TaskingApp;

class Task
{
    private int $taskId;
    private string $taskName;
    private string $taskDescription;
    private string $taskDate;
    private int $taskStatus;

    public function __construct(int $taskId, string $taskName, string $taskDescription, string $taskDate, int $taskStatus)
    {
        $this->taskId = $taskId;
        $this->taskName = $taskName;
        $this->taskDescription = $taskDescription;
        $this->taskDate = $taskDate;
        $this->taskStatus = $taskStatus;
    }

    public static function createTask(string $taskName, string $taskDescription, string $taskDate): bool
    {

        if (!InputSanitizer::checkLength($taskName, 1, 255)) {
            return false;
        }
        if (!empty($taskDescription)) {
            if (!InputSanitizer::checkLength($taskDescription, 0, 255)) {
                return false;
            }
        }
        if (!InputSanitizer::checkDate($taskDate)) {
            return false;
        }

        $details = [
            "taskName" => $taskName,
            "$taskDescription" => $taskDescription,
            "$taskDate" => $taskDate,
        ];

        InputSanitizer::sanitize($details);
        $columns = implode(', ', array_keys($details));
        $values = ':' . implode(', :', array_keys($details));
        $params = [
            "name" => $taskName,
            "description" => $taskDescription,
            "date" => $taskDate,
            "completed" => 0,
            "user_id" => $_SESSION["user"]->getUserId()
        ];
        Db::$db->insert("task", $params);
        return true;
    }

    public static function getTaskById($id): Task
    {
        $columns = [
            "task" => [
                "*"
            ],
        ];
        $params = [
            "task.id" => $id
        ];
        $result = Db::$db->select($columns, $params);
        $task = $result[0];
        return new Task($task["id"], $task["name"], $task["description"], $task["date"], $task["completed"]);
    }

    public function getTaskDate(): string
    {
        return $this->taskDate;
    }

    public function getTaskDescription(): string
    {
        return $this->taskDescription;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getTaskName(): string
    {
        return $this->taskName;
    }

    public function getTaskStatus(): string
    {
        if ($this->taskStatus == 1) {
            return "Completed";
        } else {
            return "Not completed";
        }
    }

    public function getTaskInfo(): array
    {
        return [
            "taskId" => $this->taskId,
            "taskName" => $this->taskName,
            "taskDescription" => $this->taskDescription,
            "taskDate" => $this->taskDate,
            "taskStatus" => $this->taskStatus
        ];
    }

    public function updateTaskStatus(): void
    {
        if ($this->taskStatus == 1) {
            $this->taskStatus = 0;
        } else {
            $this->taskStatus = 1;
        }
        $params = [
            "id" => $this->taskId,
            "completed" => $this->taskStatus
        ];
        Db::$db->update("task", $params);
    }
}