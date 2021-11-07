@extends('layouts.app')
@section('content')
    <h1 class="header-left mt-10">Edytuj zadanie:</h1>
    <div class="container">
        <form action="{{ route('todo.update', $todo) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="input-style-1">
                <label>Tytuł zadania:</label>
                <input type="text" name="title" value="{{ $todo->title }}"/>
            </div>
            <!-- end input -->
            <div class="input-style-1">
                <label>Opis:</label>
                <textarea type="text" name="description">{{ $todo->description }}</textarea>
            </div>
            <!-- end input -->
            <div class="select-style-1">
                <label>Status</label>
                <div class="select-position">
                    <select name="status">
                        @foreach($statuses as $status)
                            <option {{ $status == $todo->status ? 'selected' : '' }} value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- end input -->
            <button type="submit" class="btn btn-outline-success">Zapisz</button>
        </form>
    </div>
@endsection
