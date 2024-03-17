<?php

namespace App\Services;

use App\Repositories\TodoRepository;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function updateStatus($todoId, $status)
    {
        return $this->todoRepository->updateStatus($todoId, $status);
    }
}
