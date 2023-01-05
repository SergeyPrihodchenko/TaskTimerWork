<?php

use TaskTimer\BackEnd\Class\HTTP\actionHTTP\DeleteTask;
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
    $method = $request->method();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return;
}

try {
    $header = $request->header('ACTION');
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return;
}

$routes = [
    'POST' => [
        'SAVE' => SaveTask::class,
        'DELETE' => DeleteTask::class,
        'GET_TASK' => GetTasks::class,
    ]
];

if(!array_key_exists($method, $routes)) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

if(!array_key_exists($header, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $header"))->send();
}

$actionClassName = $routes[$method][$header];

$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();