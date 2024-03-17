<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
    public function updateStatus($todoId, $status)
    {
        $todo = Todo::findOrFail($todoId);
        $todo->status = $status;
        $todo->save();

        return $todo;
    }
}
