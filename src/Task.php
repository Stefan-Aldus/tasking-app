<?php

namespace TaskingApp;

class Task
{
    private int $taskId;
    private string $taskName;
    private string $taskDescription;
    private string $taskDate;
    private string $taskStatus;

    public function __construct(int $taskId, string $taskName, string $taskDescription, string $taskDate, string $taskStatus)
    {
        $this->taskId = $taskId;
        $this->taskName = $taskName;
        $this->taskDescription = $taskDescription;
        $this->taskDate = $taskDate;
        $this->taskStatus = $taskStatus;
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
        return $this->taskStatus;
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
}