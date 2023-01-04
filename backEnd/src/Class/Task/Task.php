<?php

namespace TaskTimer\BackEnd\Class\Task;

class Task {
    function __construct(
        private int $id_task,
        private string $text,
        private string $date
    )
    {
        
    }

    public function id_task(): int
    {
        return $this->id_task;
    }

    public function text(): string 
    {
        return $this->text;
    }

    public function date(): string
    {
        return $this->date;
    }

    static function validatorText($text): string 
    {
        $newText = strip_tags($text);
        $newText = htmlentities($newText);
        return $newText;
    }

    static function genDate(): string 
    {
        date_default_timezone_set('Europe/Moscow');
        
        return date('d m Y H:i');
    
    }

    static function createTask(int $id, string $text) {
        return new Task($id, Task::validatorText($text), Task::genDate());
    }
}

