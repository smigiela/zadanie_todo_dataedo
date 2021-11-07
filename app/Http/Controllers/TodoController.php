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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->repository->getAll(5);

        $statuses = Todo::$todo_statuses;

        return view('todo.index', compact('todos', 'statuses'));
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

        return redirect()->route('todo.index')->with('message', 'Poprawnie dodano zadanie.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->repository->getById($id);

        $statuses = Todo::$todo_statuses;

        return view('todo.edit', compact('todo', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TodoStoreRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TodoStoreRequest $request, $id)
    {
        $validated = $request->validated();

        $this->repository->update($id, $validated);

        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return redirect()->route('todo.index');
    }
}
