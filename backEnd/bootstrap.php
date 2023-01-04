<?php

use TaskTimer\BackEnd\Class\diContainer\DiContainer;
use TaskTimer\BackEnd\Class\Repository\RepositoryTask;

require_once './vendor/autoload.php';

$container = new DiContainer();

$container->bind(
    RepositoryTask::class,
    new RepositoryTask(new PDO('sqlite:./db.db'))
);

return $container;