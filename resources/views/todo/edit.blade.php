<x-app-layout>

    <script>
        setTimeout(function() {
            var errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.remove();
            }
        }, 5000);
    </script>

    <form action="{{ route('dashboard.update', $todo->id) }}" method="POST" class="max-w-md mx-auto mt-8">
        @csrf
        @method('PUT')

        @if (session('error'))
            <div id="errorMessage" class="bg-red-500 text-white font-bold rounded px-4 py-2 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Cím:</label>
            <input type="text" id="title" name="title" value="{{ $todo->title }}" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium text-gray-700">Prioritás:</label>
            <select id="priority" name="priority" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                <option value="Alacsony" {{ $todo->priority == 'Alacsony' ? 'selected' : '' }}>Alacsony</option>
                <option value="Közepes" {{ $todo->priority == 'Közepes' ? 'selected' : '' }}>Közepes</option>
                <option value="Magas" {{ $todo->priority == 'Magas' ? 'selected' : '' }}>Magas</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Státusz:</label>
            <select id="status" name="status" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                <option value="Aktív" {{ $todo->status == 'Aktív' ? 'selected' : '' }}>Aktív</option>
                <option value="Befejezett" {{ $todo->status == 'Befejezett' ? 'selected' : '' }}>Befejezett</option>
                <option value="Elhalasztott" {{ $todo->status == 'Elhalasztott' ? 'selected' : '' }}>Elhalasztott</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Kategória:</label>
            <input type="text" id="category" name="category" value="{{ $todo->category }}" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Kezdés dátuma:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $todo->start_date }}" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">Befejezés dátuma:</label>
            <input type="date" id="end_date" name="end_date" value="{{ $todo->end_date }}" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Feladat frissítése</button>
    </form>
</x-app-layout>
