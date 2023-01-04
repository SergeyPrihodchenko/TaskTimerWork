<?php

namespace TaskTimer\BackEnd\Class\HTTP\actionHTTP;

use Exception;
use TaskTimer\BackEnd\Class\HTTP\Request\Request;
use TaskTimer\BackEnd\Class\HTTP\Response\ErrorResponse;
use TaskTimer\BackEnd\Class\HTTP\Response\Response;
use TaskTimer\BackEnd\Class\HTTP\Response\SuccessfulResponse;
use TaskTimer\BackEnd\Class\Repository\RepositoryTask;

class GetTasks {

    function __construct(
        private RepositoryTask $repository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $tasks = $this->repository->getTasks();
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse([
            'result' => 'ok',
            'tasks' => $tasks]);
    }
}