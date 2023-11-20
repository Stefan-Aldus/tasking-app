<?php

require_once "vendor/autoload.php";

use TaskingApp\Database;
use TaskingApp\Db;
use TaskingApp\Mysql;
use TaskingApp\task;
use TaskingApp\User;

$db = new Db();
$smarty = new Smarty();

session_start();

$action = "";
if (isset($_GET["action"])) {
    $action = strtolower($_GET["action"]);
}

switch ($action) {
    case "login":
        if (!isset($_SESSION["user"])) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $user = User::login($_POST["username"], $_POST["password"]);
                if (is_object($user)) {
                    $_SESSION["user"] = $user;
                    header("Location: index.php?action=home");
                } else {
                    $smarty->assign("error", "Invalid username or password");
                }
            } else {
                $smarty->assign("error", "Please enter username and password");
                $smarty->display("login.tpl");
            }
        }
        break;

    case "logout":
        unset($_SESSION["user"]);
        $smarty->assign("info", "You have been logged out");
        $smarty->display("login.tpl");

    case "register":
        if (!isset($_SESSION["user"])) {
            if (isset($_POST["username"]) && isset($_POST["password1"]) && isset($_POST["password2"]) && isset($_POST["firstname"]) && isset($_POST["lastname"])) {
                if (User::register($_POST["username"], $_POST["password1"], $_POST["password2"], $_POST["firstname"], $_POST["lastname"])) {
                    $smarty->assign("info", "You have been registered");
                    $smarty->display("login.tpl");
                } else {
                    $smarty->assign("error", "Passwords do not match");
                    $smarty->display("register.tpl");
                }
            }
        }

    case "tasks":
        if (isset($_SESSION["user"])) {
            $smarty->assign("tasks", $_SESSION["user"]->getTasks());
            $smarty->display("tasks.tpl");
        } else {
            $smarty->assign("error", "You need to be logged in to view this page");
            $smarty->display("login.tpl");
        }
        break;

    default:
        $smarty->display("base.tpl");
}
