<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\RedirectResponse;
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
            'end_date' => 'required|date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        if ($startDate < $endDate) {
            Todo::create($request->all());
            return redirect()->route('dashboard')->with('success', 'To-Do hozzáadva!');
        } else {
            return redirect()->route('todo.create')->with('error', 'A kezdés dátuma későbbi, mint a befejezés dátuma!');
        }
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

    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todo.edit', compact('todo'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'priority' => 'required|string',
            'status' => 'required|string',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate < $endDate) {
            $todo = Todo::findOrFail($id);
            $todo->update($request->all());

            return redirect()->route('dashboard')->with('success', 'A To-Do elem sikeresen frissítve lett.');
        } else {
            $todo = Todo::findOrFail($id);
            return redirect()->route('todo.edit', $todo->id)->with('error', 'A kezdés dátuma későbbi, mint a befejezés dátuma!');
        }
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $todo = Todo::findOrFail($id);
        if ($todo->status === 'Befejezett' || $todo->status === 'Elhalasztott') {
            $todo->delete();
            return redirect()->route('dashboard')->with('success', 'A To-Do elem sikeresen törölve lett.');
        } else {
            return redirect()->route('dashboard')->with('error', 'Nem törölhető! Csak Befejezett és Elhalasztott státuszú To-Dok törölhetőek!');
        }
    }

    public function filter(Request $request)
    {
        $query = Todo::query();

        $category = $request->input('category');
        if ($category !== null) {
            $query->where('category', $category);
        }

        $priority = $request->input('priority');
        if ($priority !== null) {
            $query->where('priority', $priority);
        }

        $date = $request->input('start_date');
        if ($date !== null) {
            $query->where('start_date', '>=', $date);
        }

        $filteredTodos = $query->get();

        return response()->json([
            'filteredTodos' => $filteredTodos,
        ]);
    }
}
