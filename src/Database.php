<?php

namespace TaskingApp;

interface Database
{
    public function connect(string $server, string $user, string $password, string $database);

    public function insert(string $table, array $params);
    // UPDATE task SET completed = 1 WHERE task.id = :id
    public function update(string $table, array $params);

    public function delete();

    public function select(array $columns, array $params);

}