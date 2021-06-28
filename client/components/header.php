<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@tabler/core@1.0.0-beta3/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@tabler/core@1.0.0-beta3/dist/css/tabler.min.css">
    <link rel="stylesheet" href="/client/css/main.css">
    <script src="/client/js/app.js" type="text/javascript"></script>
    <?php if ($path == 'content'): ?>
        <script src="/client/js/content.js" type="text/javascript"></script> 
    <?php endif; ?>
    <?php if ($path == 'login'): ?>
        <script src="/client/js/login.js" type="text/javascript"></script>
    <?php endif; ?>
    <?php if ($path == 'signup'): ?>
        <script src="/client/js/signup.js" type="text/javascript"></script>
    <?php endif; ?>
    <?php if ($path == 'admin'): ?>
        <script src="/client/js/admin.js" type="text/javascript"></script>
    <?php endif; ?>
    <title><?=$title?></title>
</head>
<body class="antialiased">
<div class="wrapper">
<?php if ($path !== "login" AND $path !== 'signup'): ?>
    <?php include './client/components/sidebar.php'; ?>
    <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
        <div class="container-xl">
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm"><?=$userEmail[0]?></span>
                        <div class="d-none d-xl-block ps-2">
                            <div><?=$userEmail?></div>
                            <div class="mt-1 small text-muted"><?=$userType?></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/content?content_type=movies">
                            <span class="nav-link-title">
                                Movies
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/content?content_type=series">
                            <span class="nav-link-title">
                                Series
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/content?content_type=tv_shows">
                            <span class="nav-link-title">
                                TV Shows
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/content?content_type=sports">
                            <span class="nav-link-title">
                                Sports
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
<?php 
    endif;
?>
