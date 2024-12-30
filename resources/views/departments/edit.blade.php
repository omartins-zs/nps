@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Editar Departamento</h1>

    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nome do Departamento</label>
            <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-700" value="{{ $department->name }}" required>
        </div>

        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-800 mt-4">
            Atualizar
        </button>
    </form>
</div>
@endsection
