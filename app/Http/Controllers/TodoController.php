<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('todo.index', compact('todos'));
    }

    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'category' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Todo::create($request->all());

        return redirect()->route('dashboard')->with('success', 'To-Do hozzáadva!');
    }

    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function updateStatus(Request $request)
    {
        $todoId = $request->input('todo_id');
        $status = $request->input('status');

        $this->todoService->updateStatus($todoId, $status);

        return response()->json(['success' => true]);
    }
}
