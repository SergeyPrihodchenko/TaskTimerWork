<?php

namespace TaskTimer\BackEnd\Class\HTTP\Response;

class ErrorResponse extends Response {

    protected const SUCCESS = false;
    
    function __construct(
        private string $reason = 'Something goes wrong'
    )
    {
        
    }

    protected function payload(): array
    {
        return ['reason' => $this->reason];
    }
}