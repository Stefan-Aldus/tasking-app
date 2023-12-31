<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <title>PHP Tasks App | {block name=pageTitle}{/block}</title>
        <link rel="stylesheet" type="text/css" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css"/>
        <script src="https://kit.fontawesome.com/92b411cd61.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js" defer></script>
    </head>
    <style>
        .required-input::after {
            content: "*";
            margin-left: 3px;
            color: red;
        }
    </style>
    <body class="d-flex flex-column min-vh-100">
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light container-fluid">
                <div class="ms-4 d-grid text-light w-75">
                    <div class="row gap-1 align-items-center">
                        <a class="navbar-brand col-sm-auto">PHP Tasks App</a>
                        <a class="nav-link col-sm" href="/index.php?action=home">Home</a>

                        {if isset($smarty.session.user)}
                            <a class="nav-link col-sm" href="/index.php?action=tasks">Tasks</a>
                            <a class="nav-link col-sm" href="/index.php?action=addtask">Add Task</a>
                        {/if}
                    </div>
                </div>

                <div class="ms-4 d-grid text-light">
                    <div class="row gap-5">
                        {if !isset($smarty.session.user)}
                            <a class="nav-link col-sm" href="/index.php?action=login">Login</a>
                            <a class="nav-link col-sm" href="/index.php?action=register">Register</a>
                        {else}
                            <a class="nav-link col-sm"
                               href="/index.php?action=account">{$smarty.session.user->getUsername()}</a>
                            <a class="nav-link col-sm" href="/index.php?action=logout">Logout</a>
                        {/if}
                    </div>
                </div>
            </nav>
        </header>
        <main class="container-fluid w-100">
            {if isset($info)}
                <div class="alert alert-info alert-dismissible fade show w-100" role="alert">
                    {$info}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            {/if}
            {if isset($error)}
                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                    {$error}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            {/if}
            {block name="content"}{/block}
        </main>
        <footer class="container border-top border-2 border-dark-subtle bg-light-subtle mt-auto py-3 min-vw-100">
            <div class="d-flex flex-wrap justify-content-between align-items-center w-100">
                <div class="col-md-7 d-flex flex-column">
                    <span class="mb-3 mb-md-0">Tasking App made by Stefan Aldus</span>
                    <span class="mb-3 mb-md-0 ">Used Technologies: PHP, MySQL, HTML/Bootstrap CSS, Smarty</span>
                </div>
                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3">
                        <a class="text-muted" href="https://www.linkedin.com/in/stefan-aldus-506b8a258/">
                            <i class="fa-brands fa-linkedin fa-2x"></i>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="text-muted" href="https://github.com/Stefan-Aldus">
                            <i class="fa-brands fa-github fa-2x"></i>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="text-muted" href="https://github.com/Stefan-Aldus/tasking-app">
                            <i class="fa-brands fa-square-github fa-2x"></i>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="text-muted" href="https://twitter.com/Stefan0_">
                            <i class="fa-brands fa-x-twitter fa-2x"></i>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="text-muted" href="#">
                            <i class="fa-brands fa-discord fa-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </footer>
    </body>
</html>
