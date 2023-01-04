<?php declare(strict_types=1);

namespace TaskTimer\BackEnd\Class\HTTP\Response;

class SuccessfulResponse extends Response {

    protected const SUCCESS = true;

    function __construct(
        private array $data = []
    )
    {
        
    }

    protected function payload(): array
    {
        return ['data' => $this->data];
    }
}