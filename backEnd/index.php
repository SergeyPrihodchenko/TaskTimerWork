<?php

use TaskTimer\BackEnd\Class\HTTP\actionHTTP\DeleteTask;
use TaskTimer\BackEnd\Class\HTTP\actionHTTP\GetIdTask;
use TaskTimer\BackEnd\Class\HTTP\actionHTTP\GetTasks;
use TaskTimer\BackEnd\Class\HTTP\actionHTTP\SaveTask;
use TaskTimer\BackEnd\Class\HTTP\Request\Request;
use TaskTimer\BackEnd\Class\HTTP\Response\ErrorResponse;

require_once './bootstrap.php';

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input')
);

try {
    $path = $request->path();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()));
    return;
}

try {
    $method = $request->method();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return;
}

$routes = [
    'POST' => [
        '/task/save' => SaveTask::class,
        '/task/delete' => DeleteTask::class,
        '/' => GetTasks::class,
    ]
];

if(!array_key_exists($method, $routes)) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

if(!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $path"))->send();
}

$actionClassName = $routes[$method][$path];

$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();