<x-app-layout>

    <h1>To-Do List</h1>

    @if ($todos->isEmpty())
        <p>Nincs még To-Do elem.</p>
    @else
        <ul>
            @foreach ($todos as $todo)
                <li>{{ $todo->title }} - Prioritás: {{ $todo->priority }}, Státusz: {{ $todo->status }}, Kategória: {{ $todo->category }}, Kezdés: {{ $todo->start_date }}, Befejezés: {{ $todo->end_date }}</li>
            @endforeach
        </ul>
    @endif

</x-app-layout>
