@extends('layouts.app')

@section('content')
    <h1>Edit Department</h1>

    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Department Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $department->name }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
