<?php

use Project\Application;

$app = Application::getInstance();
$app->addRoute('home','/{page}', ['GET'],
    [
        'controller' => 'BlogController',
        'method' => 'overview',
        'page' => 1,
    ], ['page' => '\d+']);

$app->addRoute('blog_details', '/blog/{id}', ['GET'],
    [
        'controller' => 'BlogController',
        'method' => 'details'
    ], ['id' => '\d+']);

$app->addRoute('login', '/login', ['GET'], ['controller' => 'UserController', 'method' => 'login']);
$app->addRoute('login_verify', '/login', ['POST'], ['controller' => 'UserController', 'method' => 'loginVerify']);
$app->addRoute('logout', '/logout', ['GET'], ['controller' => 'UserController', 'method' => 'logout']);
$app->addRoute('register', '/register', ['GET'], ['controller' => 'UserController', 'method' => 'register']);
$app->addRoute('register_verify', '/register', ['POST'], ['controller' => 'UserController', 'method' => 'registerVerify']);
$app->addRoute('page_not_found', '/*', ['GET'], ['controller' => 'ErrorController', 'method' => 'pageNotFound']);