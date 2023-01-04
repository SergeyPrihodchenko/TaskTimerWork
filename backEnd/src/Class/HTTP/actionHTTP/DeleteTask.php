<?php

namespace TaskTimer\BackEnd\Class\HTTP\actionHTTP;

use Exception;
use TaskTimer\BackEnd\Class\HTTP\Request\Request;
use TaskTimer\BackEnd\Class\HTTP\Response\ErrorResponse;
use TaskTimer\BackEnd\Class\HTTP\Response\Response;
use TaskTimer\BackEnd\Class\HTTP\Response\SuccessfulResponse;
use TaskTimer\BackEnd\Class\Repository\RepositoryTask;

class DeleteTask {
    function __construct(
        private RepositoryTask $repository
    )
    {
        
    }

    public function handle(Request $request): Response   
    {
        try {
            $id = $request->jsonBodyField('id_task');
            if($id === null) {
                throw new Exception('No data id_task');
            }
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $this->repository->delete($id);
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse([
            'result' => 'ok',
            'task_deleted' => $id
        ]);
    } 
}