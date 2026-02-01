<?php

session_start();

$basePath = '/basic_web';
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = str_replace($basePath, '', $uri);
$path = $path ?: '/';


if ($path === '/') {
    $page = include 'pages/home.php';
} elseif ($path === '/login') {
    $page = include 'pages/login.php';
} elseif ($path === '/feedback') {
    $page = include 'pages/feedback.php';
} elseif ($path === '/logout') {
    $page = include 'pages/logout.php';
} else {
    http_response_code(404);
    $page = include 'pages/404.php';
}

$title = $page['title'];
$content = $page['content'];

require 'layout.php';