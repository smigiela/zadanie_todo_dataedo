@extends('layouts.app')
@section('content')


    <h1 class="header-left mt-10">Zadania:</h1>
    <div class="mt-20">
        <a href="{{ route('todo.create') }}" class="btn btn-outline-success">Dodaj</a>
    </div>
    <div class="container row mt-10">
        @foreach($todos as $todo)
            <div class="col mb-20">
                <div class="card">
                    <div class="card-header
                        @if($todo->status == 'in_progress') bg-blue-300
                        @elseif($todo->status == 'on_hold') bg-secondary-600
                        @elseif($todo->status == 'completed') bg-success-600 @endif
                        ">{{ $todo->title }}</div>
                    <div class="card body" style="padding: 5px;">
                        <small>Opis:</small>
                        {{ $todo->description ?? '' }}

                        <hr>

                        <small>Status:</small>
                        @if($todo->status == 'on_hold')
                            <p>Oczekuje</p>
                        @elseif($todo->status == 'in_progress')
                            <p>W trakcie</p>
                        @elseif($todo->status == 'completed')
                            <p>Zakończone</p>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <div class="d-inline">
                            <a href="{{ route('todo.edit', $todo) }}" class="btn btn-xs btn-secondary">Edytuj</a>
                            <form action="{{route('todo.destroy', $todo)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger">Usuń</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
            {{ $todos->links() }}
    </div>
@endsection
