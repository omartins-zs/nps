@extends('layouts.app')

@section('title', 'Departamentos')

@section('content')
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Departamentos</h1>
            <a href="{{ route('departments.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-800">
                Criar Novo
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="border border-gray-300 dark:border-gray-600 p-2 text-gray-900 dark:text-gray-100">ID</th>
                        <th class="border border-gray-300 dark:border-gray-600 p-2 text-gray-900 dark:text-gray-100">Nome
                        </th>
                        <th class="border border-gray-300 dark:border-gray-600 p-2 text-gray-900 dark:text-gray-100">Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="border border-gray-300 dark:border-gray-600 p-2 text-gray-900 dark:text-gray-200">
                                {{ $department->id }}</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 text-gray-900 dark:text-gray-200">
                                {{ $department->name }}</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 text-gray-900 dark:text-gray-200">
                                <a href="{{ route('departments.show', $department->id) }}"
                                    class="text-blue-500 dark:text-blue-400 hover:underline">
                                    <i class="fas fa-eye"></i> Ver
                                </a> |
                                <a href="{{ route('departments.edit', $department->id) }}"
                                    class="text-yellow-500 dark:text-yellow-400 hover:underline">
                                    <i class="fas fa-edit"></i> Editar
                                </a> |
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">
                                        <i class="fas fa-trash-alt"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
