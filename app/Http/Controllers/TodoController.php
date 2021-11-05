<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Models\Todo;
use App\Repositories\TodoRepository;

class TodoController extends Controller
{
    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->repository->getAll(5);

        return view('todo.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Todo::$todo_statuses;

        return view('todo.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TodoStoreRequest $request)
    {
        $validated = $request->validated();

        $this->repository->save($validated);

        return redirect()->route('todo.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        $statuses = Todo::$todo_statuses;

        return view('todo.edit', compact('todo', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TodoStoreRequest $request, Todo $todo)
    {
        $validated = $request->validated();

        $this->repository->update($todo->id, $validated);

        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Todo $todo)
    {
        $this->repository->delete($todo->id);

        return redirect()->route('todo.index');
    }
}
