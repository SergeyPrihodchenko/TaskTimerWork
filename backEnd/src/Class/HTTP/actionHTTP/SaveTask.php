<?php

namespace TaskTimer\BackEnd\Class\HTTP\actionHTTP;

use Exception;
use TaskTimer\BackEnd\Class\HTTP\Request\Request;
use TaskTimer\BackEnd\Class\HTTP\Response\ErrorResponse;
use TaskTimer\BackEnd\Class\HTTP\Response\Response;
use TaskTimer\BackEnd\Class\HTTP\Response\SuccessfulResponse;
use TaskTimer\BackEnd\Class\Repository\RepositoryTask;
use TaskTimer\BackEnd\Class\Task\Task;

class SaveTask {
    function __construct(
        private RepositoryTask $repository   
    )
    {
        
    }

    public function handle(Request $request): Response
    {
        try {
            $id_task = $request->jsonBodyField('id_task');
            $text = $request->jsonBodyField('text');
            if ($id_task === null && $text === null) {
                throw new Exception("Not data in: id_task or text");
            }
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $this->repository->save(Task::createTask($id_task, $text));
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }
        
        return new SuccessfulResponse(['result' => 'ok']);
    }
}