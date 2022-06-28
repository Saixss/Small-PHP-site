<?php /** @var bool $isLogged */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum</title>
    <base href="http://localhost/Forum/">
    <link rel="stylesheet" href="public/styles/style.css">
    <link rel="stylesheet" href="public/styles/colors.css">
    <link rel="stylesheet" href="public/styles/fonts.css">
    <link rel="stylesheet" href="public/styles/icons.css">
    <link rel="stylesheet" href="public/styles/forms.css">
    <link rel="stylesheet" href="public/styles/home.css">
    <link rel="stylesheet" href="public/styles/thread.css">
    <link rel="stylesheet" href="public/styles/page-not-found-404.css">
</head>
<body>
<nav id="head-nav" class="navbar navbar-fixed-top">
    <div class="navbar-inner clearfix">
        <ul class="nav">
            <?php if($isLogged): ?>
            <?php if($_SERVER["REQUEST_URI"] !== "/" . parse_ini_file("config/config.ini")["root"] . "/"): ?>
            <li>
                <a style="cursor: pointer" onclick="history.back()">Back</a>
            </li>
            <?php endif; ?>
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="profile">Profile</a>
            </li>
            <li>
                <a href="logout">Logout</a>
            </li>
            <?php else: ?>
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="register">Register</a>
            </li>
            <li>
                <a href="login">Login</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>