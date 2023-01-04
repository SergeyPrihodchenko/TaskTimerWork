<?php

namespace TaskTimer\BackEnd\Class\HTTP\actionHTTP;

use Exception;
use TaskTimer\BackEnd\Class\HTTP\Request\Request;
use TaskTimer\BackEnd\Class\HTTP\Response\ErrorResponse;
use TaskTimer\BackEnd\Class\HTTP\Response\Response;
use TaskTimer\BackEnd\Class\HTTP\Response\SuccessfulResponse;
use TaskTimer\BackEnd\Class\Repository\RepositoryTask;

class GetIdTask {

    function __construct(
        private RepositoryTask $repository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $id_task = $this->repository->maxIdTask();
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse([
            'result' => 'ok',
            'id_task' => $id_task
        ]);
    }
}