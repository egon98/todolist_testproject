<?php

namespace App\Http\Controllers;

use App\Models\Todo;

class DashboardController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('dashboard', compact('todos'));
    }

}
