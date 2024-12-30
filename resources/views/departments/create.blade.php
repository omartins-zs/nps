@extends('layouts.app')

@section('title', 'Criar Departamento')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Criar Departamento</h1>

    <form action="{{ route('departments.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nome do Departamento</label>
            <input type="text" name="name" id="name" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
            Salvar
        </button>
    </form>
</div>
@endsection
