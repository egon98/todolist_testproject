<x-app-layout>
    <h1 class="text-center mt-10 mb-10 text-3xl font-bold mb-4">To-Do Lista</h1>

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
    @if (!$todos->isEmpty())
        <form id="filter-form" class="mb-6 max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-xl">
            @csrf
            <div class="md:flex justify-between md:space-x-4 p-4">
                <div class="w-full md:w-1/3 mb-3 md:mb-0">
                    <input placeholder="Kategória" name="category" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="w-full md:w-1/3 mb-3 md:mb-0">
                    <select name="priority" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Prioritás</option>
                        <option value="Alacsony">Alacsony</option>
                        <option value="Közepes">Közepes</option>
                        <option value="Magas">Magas</option>
                    </select>
                </div>
                <div class="w-full md:w-1/3 mb-3 md:mb-0">
                    <input type="date" name="start_date" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Szűrés</button>
                </div>
            </div>
        </form>
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

    <script src="{{ asset('js/todo_update_status.js') }}"></script>



    @foreach ($todos as $todo)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const filterForm = document.getElementById('filter-form');

                filterForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const todoList = document.getElementById('todo-list'); // Assuming the table body container
                    const todoTableHead = document.getElementById('todoTableHead');
                    const todoTable = document.getElementById('todoTable');

                    fetch('{{ route('todo.filter') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.filteredTodos.length === 0) {
                                todoTableHead.style.display = 'none';
                                todoTable.style.marginTop = '20px';
                                todoList.innerHTML = '<tr class="mt-10"><td colspan="7" class="mt-10 text-center">Nincs találat.</td></tr>';
                            } else {
                                todoList.innerHTML = ''; // Clear the current content of the table body
                                data.filteredTodos.forEach(todo => {
                                    const row = document.createElement('tr');

                                    const titleCell = document.createElement('td');
                                    titleCell.className = 'text-center border px-4 py-2';
                                    titleCell.textContent = todo['title'];
                                    row.appendChild(titleCell);

                                    const priorityCell = document.createElement('td');
                                    priorityCell.className = 'text-center border px-4 py-2';
                                    priorityCell.textContent = todo['priority'];
                                    row.appendChild(priorityCell);

                                    const statusCell = document.createElement('td');
                                    statusCell.className = 'text-center border px-4 py-2';
                                    statusCell.textContent = todo['status'];
                                    row.appendChild(statusCell);

                                    const categoryCell = document.createElement('td');
                                    categoryCell.className = 'text-center border px-4 py-2';
                                    categoryCell.textContent = todo['category'];
                                    row.appendChild(categoryCell);

                                    const startDateCell = document.createElement('td');
                                    startDateCell.className = 'text-center border px-4 py-2';
                                    startDateCell.textContent = todo['start_date'];
                                    row.appendChild(startDateCell);

                                    const endDateCell = document.createElement('td');
                                    endDateCell.className = 'text-center border px-4 py-2';
                                    endDateCell.textContent = todo['end_date'];
                                    row.appendChild(endDateCell);

                                    const actionCell = document.createElement('td');
                                    actionCell.className = 'border px-4 py-2';

                                    const editLink = document.createElement('a');
                                    editLink.href = '{{ route('todo.edit', $todo->id) }}';
                                    editLink.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded';
                                    editLink.textContent = 'Szerkesztés';
                                    actionCell.appendChild(editLink);

                                    const deleteForm = document.createElement('form');
                                    deleteForm.action = '{{ route('todo.destroy', $todo->id) }}';
                                    deleteForm.method = 'POST';
                                    deleteForm.className = 'inline-block';

                                    const csrfTokenInput = document.createElement('input');
                                    csrfTokenInput.type = 'hidden';
                                    csrfTokenInput.name = '_token';
                                    csrfTokenInput.value = '{{ csrf_token() }}';
                                    deleteForm.appendChild(csrfTokenInput);

                                    const methodInput = document.createElement('input');
                                    methodInput.type = 'hidden';
                                    methodInput.name = '_method';
                                    methodInput.value = 'DELETE';
                                    deleteForm.appendChild(methodInput);

                                    const deleteButton = document.createElement('button');
                                    deleteButton.type = 'submit';
                                    deleteButton.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded';
                                    deleteButton.textContent = 'Törlés';
                                    deleteForm.appendChild(deleteButton);

                                    actionCell.appendChild(deleteForm);
                                    row.appendChild(actionCell);

                                    todoList.appendChild(row);
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        </script>
    @endforeach

    @if ($todos->isEmpty())
        <p class="text-center">Nincs még To-Do elem.</p>
    @else
        <div class="overflow-x-auto">
            <table id="todoTable" class="table-auto w-full border-collapse">
                <thead id="todoTableHead">
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
                <tbody id="todo-list">
                @foreach ($todos as $todo)
                    <tr>
                        <td class="text-center border px-4 py-2">{{ $todo->title }}</td>
                        <td class="text-center border px-4 py-2">{{ $todo->priority }}</td>
                        <td class="text-center border px-4 py-2">
                            <select class="status-select text-center bg-white border rounded px-3 pr-8 py-1" data-todo-id="{{ $todo->id }}">
                                <option value="Aktív" {{ $todo->status === 'Aktív' ? 'selected' : '' }}>Aktív</option>
                                <option value="Befejezett" {{ $todo->status === 'Befejezett' ? 'selected' : '' }}>Befejezett</option>
                                <option value="Elhalasztott" {{ $todo->status === 'Elhalasztott' ? 'selected' : '' }}>Halasztott</option>
                            </select>
                        </td>
                        <td class="text-center border px-4 py-2">{{ $todo->category }}</td>
                        <td class="text-center border px-4 py-2">{{ $todo->start_date }}</td>
                        <td class="text-center border px-4 py-2">{{ $todo->end_date }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('todo.edit', $todo->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Szerkesztés</a>
                            <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="inline-block">
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
