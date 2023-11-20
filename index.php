<?php

require_once "vendor/autoload.php";

use TaskingApp\Db;
use TaskingApp\InputSanitizer;
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
            if (!isset($_POST["submit"])) {
                $smarty->display("login.tpl");
            } elseif (isset($_POST["username"]) && isset($_POST["password"])) {
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
            if (!isset($_POST["submit"])) {
                $smarty->display("register.tpl");
            } elseif (!empty($_POST["username"]) && !empty($_POST["password1"]) && !empty($_POST["password2"]) && !empty($_POST["firstname"]) && !empty($_POST["lastname"])) {
                if (InputSanitizer::checkLength($_POST["password1"], 6,)) {
                    $smarty->assign("error", "Password must be at least 6 characters long.");
                    $smarty->display("register.tpl");
                } elseif (User::checkUserAvailable($_POST["username"])) {
                    if (User::register($_POST["username"], $_POST["password1"], $_POST["password2"], $_POST["firstname"], $_POST["lastname"])) {
                        $smarty->assign("info", "Your account has been made, you can now log in.");
                        $smarty->display("login.tpl");
                    } else {
                        $smarty->assign("error", "Passwords do not match, please try again.");
                        $smarty->display("register.tpl");
                    }
                } else {
                    $smarty->assign("error", "Username already taken, please choose another one.");
                    $smarty->display("register.tpl");
                }
            } else {
                $smarty->assign("error", "Please fill in all fields.");
                $smarty->display("register.tpl");
            }
        }
        break;

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
