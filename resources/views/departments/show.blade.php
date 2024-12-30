<!-- resources/views/departments/show.blade.php -->
<!-- Show -->
@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $department->name }}</h1>

    <div class="mt-4">
        <a href="{{ route('departments.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-800 inline-block mr-2">
            Voltar para a lista
        </a>
        <a href="{{ route('departments.edit', $department->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-700 dark:bg-yellow-600 dark:hover:bg-yellow-800 inline-block">
            Editar
        </a>
    </div>
</div>
@endsection
