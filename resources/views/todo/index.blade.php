@extends('layouts.app')
@section('content')

    <div class="container mt-25">

        <form action="{{ route('todo.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="input-style-1">
                <label>Tytuł nowego zadania:</label>
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

    <hr>

    <div class="container m-auto mt-10">

        <h2 class="header-left mt-25 mb-50">Zadania:</h2>

        @forelse($todos as $todo)
            <div class="mb-20">
                <div class="card">
                    <a data-bs-toggle="collapse" href="#collapseExample{{$todo->id}}" role="button" aria-expanded="false"
                       aria-controls="collapseExample" class="card-header
                        @if($todo->status == 'in_progress') bg-blue-300
                        @elseif($todo->status == 'on_hold') bg-secondary-600
                        @elseif($todo->status == 'completed') bg-success-600 @endif
                        ">{{ $todo->title }} <br> <small>{{ \Carbon\Carbon::make($todo->created_at)->diffForHumans() }}</small>
                    </a>
                    <div class="collapse" id="collapseExample{{$todo->id}}">
                        <div class="card-body" style="padding: 5px;">
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
                            <div class="btn-group">
                                <a href="{{ route('todo.edit', $todo) }}" class="btn btn-xs btn-secondary">
                                    <i class="lni lni-pencil"></i>
                                </a>
                                <form action="{{route('todo.destroy', $todo)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger">
                                        <i class="lni lni-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>Nie ma nic do pokazania</p>
        @endforelse
        {{ $todos->links() }}
    </div>
@endsection
