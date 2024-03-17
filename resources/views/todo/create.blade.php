<x-app-layout>
    <form action="{{ route('todo.store') }}" method="POST" class="max-w-md mx-auto mt-8">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Cím:</label>
            <input type="text" id="title" name="title" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium text-gray-700">Prioritás:</label>
            <select id="priority" name="priority" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                <option value="Alacsony">Alacsony</option>
                <option value="Közepes">Közepes</option>
                <option value="Magas">Magas</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Státusz:</label>
            <select id="status" name="status" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                <option value="Aktív">Aktív</option>
                <option value="Befejezett">Befejezett</option>
                <option value="Elhalasztott">Elhalasztott</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Kategória:</label>
            <input type="text" id="category" name="category" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Kezdés dátuma:</label>
            <input type="date" id="start_date" name="start_date" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">Befejezés dátuma:</label>
            <input type="date" id="end_date" name="end_date" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Feladat létrehozása</button>
    </form>
</x-app-layout>

