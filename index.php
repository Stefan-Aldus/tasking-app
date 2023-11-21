<?php

require_once "vendor/autoload.php";

use TaskingApp\Db;
use TaskingApp\InputSanitizer;
use TaskingApp\Task;
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
        // If the user is not logged in, display the login form
        if (!isset($_SESSION["user"])) {
            // If the form has not been submitted, display the login form
            if (!isset($_POST["submit"])) {
                $smarty->display("login.tpl");
                // If the form has been submitted, check if all fields are filled in
            } elseif (isset($_POST["username"]) && isset($_POST["password"])) {
                $user = User::login($_POST["username"], $_POST["password"]);
                // If the login is successful, redirect to the home page
                if (is_object($user)) {
                    $_SESSION["user"] = $user;
                    header("Location: index.php?action=home");
                    // If the login is unsuccessful, display an error message
                } else {
                    $smarty->assign("error", "Invalid username or password");
                }
                // If the form has been submitted, but the fields are not filled in, display an error message
            } else {
                $smarty->assign("error", "Please enter username and password");
                $smarty->display("login.tpl");
            }
        }
        break;

    case "logout":
        unset($_SESSION["user"]);
        header("Location: index.php?action=login");
        break;

    case "register":
        // If the user is not logged in, display the register form
        if (!isset($_SESSION["user"])) {
            // If the form has not been submitted, display the register form
            if (!isset($_POST["submit"])) {
                $smarty->display("register.tpl");
                // If the form has been submitted, check if all fields are filled in
            } elseif (!empty($_POST["username"]) && !empty($_POST["password1"]) && !empty($_POST["password2"]) && !empty($_POST["firstname"]) && !empty($_POST["lastname"])) {
                // If the length of the password is not 6 or more characters, display an error message
                if (InputSanitizer::checkLength($_POST["password1"], 6,)) {
                    $smarty->assign("error", "Password must be at least 6 characters long.");
                    $smarty->display("register.tpl");
                    // If the username is available, attempt to register the user
                } elseif (User::checkUserAvailable($_POST["username"])) {
                    // If the registration is successful, display a success message
                    if (User::register($_POST["username"], $_POST["password1"], $_POST["password2"], $_POST["firstname"], $_POST["lastname"])) {
                        $smarty->assign("info", "Your account has been made, you can now log in.");
                        $smarty->display("login.tpl");
                        // If the registration is unsuccessful, display an error message
                    } else {
                        $smarty->assign("error", "Passwords do not match, please try again.");
                        $smarty->display("register.tpl");
                    }
                    // If the username is not available, display an error message
                } else {
                    $smarty->assign("error", "Username already taken, please choose another one.");
                    $smarty->display("register.tpl");
                }
                // If the form has been submitted, but the fields are not filled in, display an error message
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

    case "addtask":
        if (isset($_SESSION["user"])) {
            if (!isset($_POST["submit"])) {
                $smarty->display("addtask.tpl");
            } else {
                if (!empty($_POST["date"]) && !empty($_POST["name"])) {
                    if (!empty($_POST["description"])) {
                        Task::createTask($_POST["name"], $_POST["description"], $_POST["date"]);
                    } else {
                        Task::createTask($_POST["name"], "", $_POST["date"]);
                    }
                    $smarty->assign("info", "Task added successfully!");
                    $smarty->display("tasks.tpl");
                } else {
                    $smarty->assign("error", "Please fill in all fields.");
                    $smarty->display("addtask.tpl");
                }
            }
        } else {
            $smarty->assign("error", "You need to be logged in to view this page");
            $smarty->display("login.tpl");
        }
        break;

    case "description":
        if (isset($_POST["finish"])) {
            $task = Task::getTaskById($_POST["id"]);
            $task->updateTaskStatus();
            header("Location: index.php?action=tasks");
        } elseif (isset($_POST["description"])) {
            $task = Task::getTaskById($_POST["id"]);
            $smarty->assign("task", $task);
            $smarty->display("task.tpl");
        } elseif (isset($_POST["descriptionfinish"])) {
            $task = Task::getTaskById($_POST["id"]);
            $task->updateTaskStatus();
            $smarty->assign("task", $task);
            $smarty->display("task.tpl");
        } else {
            $smarty->assign("error", "You need to be logged in to view this page");
            $smarty->display("login.tpl");
        }
        break;

    case "account":
        if (isset($_SESSION["user"])) {
            $smarty->assign("user", $_SESSION["user"]);
            $smarty->display("account.tpl");
        } else {
            $smarty->assign("error", "You need to be logged in to view this page");
            $smarty->display("login.tpl");
        }
        break;

    case "editaccount":
        if (isset($_SESSION["user"])) {
            if (isset($_POST["editusername"])) {
                $smarty->assign("user", $_SESSION["user"]);
                $smarty->assign("type", "username");
                $smarty->display("editaccount.tpl");
            } elseif (isset($_POST["editpassword"])) {
                $smarty->assign("user", $_SESSION["user"]);
                $smarty->assign("type", "password");
                $smarty->display("editaccount.tpl");
            } else {
                $smarty->display("404.tpl");
            }
        } else {
            $smarty->assign("error", "You need to be logged in to view this page");
            $smarty->display("login.tpl");
        }
        break;

    case "updateaccount":
        if (isset($_SESSION["user"])) {
            if (isset($_POST["updateUsername"])) {
                if (!empty($_POST["username"])) {
                    if (User::checkUserAvailable($_POST["username"])) {
                        $_SESSION["user"]->updateUsername($_POST["username"]);
                        $smarty->assign("info", "Username updated successfully!");
                        header("Location: index.php?action=account");
                    } else {
                        $smarty->assign("error", "Username already taken, please choose another one.");
                        $smarty->display("editaccount.tpl");
                    }
                } else {
                    $smarty->assign("error", "Please fill in all fields.");
                    $smarty->display("editaccount.tpl");
                }
            } elseif (isset($_POST["updatePassword"])) {
                if (!empty($_POST["password1"]) && !empty($_POST["password2"])) {
                    if ($_POST["password1"] === $_POST["password2"]) {
                        if (InputSanitizer::checkLength($_POST["password1"], 6)) {
                            $_SESSION["user"]->updatePassword($_POST["password1"], $_POST["password2"], $_POST["currentpassword"]);
                            header("Location: index.php?action=account");
                        } else {
                            $smarty->assign("error", "Password must be at least 6 characters long.");
                            $smarty->display("editaccount.tpl");
                        }
                    } else {
                        $smarty->assign("error", "Passwords do not match, please try again.");
                        $smarty->display("editaccount.tpl");
                    }
                } else {
                    $smarty->assign("error", "Please fill in all fields.");
                    $smarty->display("editaccount.tpl");
                }
            } else {
                $smarty->display("404.tpl");
            }
        }
        break;
    case "home":
        $smarty->display("home.tpl");
        break;

    default:
        $smarty->display("404.tpl");
}
