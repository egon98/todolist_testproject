<x-app-layout>
    <h1 class="text-center mt-10 mb-10 text-3xl font-bold mb-4">To-Do List</h1>

    @if (session('error'))
        <div id="errorMessage" class="bg-red-500 text-white font-bold rounded px-4 py-2 mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div id="successMessage" class="bg-green-500 text-white font-bold rounded px-4 py-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <script>
        setTimeout(function() {
            var errorMessage = document.getElementById('errorMessage');
            var successMessage = document.getElementById('successMessage');
            if (errorMessage) {
                errorMessage.remove();
            }
            if (successMessage) {
                successMessage.remove();
            }
        }, 5000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelects = document.querySelectorAll('.status-select');

            statusSelects.forEach(select => {
                select.addEventListener('change', function () {
                    const todoId = this.dataset.todoId;
                    const status = this.value;

                    fetch('/todo/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            todo_id: todoId,
                            status: status
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Feladat állapota frissítve!');
                            } else {
                                throw new Error('Failed to update status');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>

    @if ($todos->isEmpty())
        <p>Nincs még To-Do elem.</p>
    @else
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead>
                <tr>
                    <th class="px-4 py-2">Cím</th>
                    <th class="px-4 py-2">Prioritás</th>
                    <th class="px-4 py-2">Státusz</th>
                    <th class="px-4 py-2">Kategória</th>
                    <th class="px-4 py-2">Kezdés</th>
                    <th class="px-4 py-2">Befejezés</th>
                    <th class="px-4 py-2">Műveletek</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($todos as $todo)
                    <tr>
                        <td class="text-center border px-4 py-2">{{ $todo->title }}</td>
                        <td class="text-center border px-4 py-2">{{ $todo->priority }}</td>
                        <td class="text-center border px-4 py-2">
                            <select class="status-select text-center bg-white border rounded px-3 pr-8 py-1" data-todo-id="{{ $todo->id }}">
                                <option value="Aktív" {{ $todo->status === 'Aktív' ? 'selected' : '' }}>Aktív</option>
                                <option value="Befejezett" {{ $todo->status === 'Befejezett' ? 'selected' : '' }}>Befejezett</option>
                                <option value="Halasztott" {{ $todo->status === 'Halasztott' ? 'selected' : '' }}>Halasztott</option>
                            </select>
                        </td>
                        <td class="text-center border px-4 py-2">{{ $todo->category }}</td>
                        <td class="text-center border px-4 py-2">{{ $todo->start_date }}</td>
                        <td class="text-center border px-4 py-2">{{ $todo->end_date }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('dashboard.edit', $todo->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Szerkesztés</a>
                            <form action="{{ route('dashboard.destroy', $todo->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Törlés</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>
