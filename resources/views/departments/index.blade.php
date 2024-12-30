@extends('layouts.app')

@section('title', 'Departamentos')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold">Departamentos</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('departments.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4 inline-block">Criar Novo</a>

    <table class="mt-4 w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 p-2">ID</th>
                <th class="border border-gray-300 p-2">Nome</th>
                <th class="border border-gray-300 p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td class="border border-gray-300 p-2">{{ $department->id }}</td>
                    <td class="border border-gray-300 p-2">{{ $department->name }}</td>
                    <td class="border border-gray-300 p-2">
                        <a href="{{ route('departments.show', $department->id) }}" class="text-blue-500 hover:underline">Ver</a> |
                        <a href="{{ route('departments.edit', $department->id) }}" class="text-yellow-500 hover:underline">Editar</a> |
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
