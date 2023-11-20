<?php

namespace TaskingApp;

class Db
{
    public static Mysql $db;

    public function __construct()
    {
        self::$db = new Mysql();
        self::$db->connect("localhost", "root", "root", "calendarapp");
    }
}