@extends('layouts.app')

@section('title', 'Criar Departamento')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold">Criar Departamento</h1>
    <form action="{{ route('departments.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-bold">Nome:</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
    </form>
</div>
@endsection
