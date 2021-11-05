@extends('layouts.app')
@section('content')
    <h1 class="header-left mt-10">Dodaj zadanie</h1>
    <div class="container">
        <form action="{{ route('todo.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="input-style-1">
                <label>Tytuł zadania:</label>
                <input type="text" name="title" />
            </div>
            <!-- end input -->
            <div class="input-style-1">
                <label>Opis:</label>
                <textarea type="text" name="description"></textarea>
            </div>
            <!-- end input -->
            <div class="select-style-1">
                <label>Status</label>
                <div class="select-position">
                    <select name="status">
                        <option disabled selected value="">Wybierz status...</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- end input -->
            <button type="submit" class="btn btn-outline-success">Zapisz</button>
        </form>
    </div>
@endsection
