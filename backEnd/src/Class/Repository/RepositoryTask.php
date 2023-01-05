<?php

namespace TaskTimer\BackEnd\Class\Repository;

use Exception;
use PDO;
use TaskTimer\BackEnd\Class\Task\Task;

class RepositoryTask {
    function __construct(
        private PDO $connect
    )
    {
        
    }

    public function save(Task $task): void 
    {
        $statement = $this->connect->prepare("INSERT INTO tasks (name, date_started) VALUES (:text, :date);");
        $statement->execute([
            ':text' => $task->text(),
            ':date' => $task->date()
        ]);
    }

    public function delete($id): void
    {
        $statement = $this->connect->prepare('DELETE FROM tasks WHERE id = :id;');
        $statement->execute([
            ':id' => $id
        ]);
    }

    public function maxIdTask():int
    {
        try {
            $statement = $this->connect->query('SELECT MAX(id) FROM tasks;');
            $id_task = $statement->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return (int)$id_task['MAX(id)'];
    }

    public function getTasks(): array
    {

        $tasks = $this->connect->query('SELECT * FROM tasks');

        $data = [];

        while ($task = $tasks->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $task;
        }

        return $data;
    }
}