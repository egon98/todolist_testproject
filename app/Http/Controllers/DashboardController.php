<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('dashboard', compact('todos'));
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

        $todo = Todo::findOrFail($id);
        $todo->update($request->all());

        return redirect()->route('dashboard')->with('success', 'A To-Do elem sikeresen frissítve lett.');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $todo = Todo::findOrFail($id);
        if ($todo->status === 'Befejezett' || $todo->status === 'Elhalasztott') {
            $todo->delete();
            return redirect()->route('dashboard')->with('success', 'A To-Do elem sikeresen törölve lett.');
        } else {
            return redirect()->route('dashboard')->with('error', 'Nem törölhető! A Todo státusza nem engedi a törlést.');
        }
    }
}
