<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
    /**
     * @param $limit
     * @return mixed
     */
    public function getAll($limit)
    {
        return Todo::where('user_id', auth()->id())->orderBy('status')->paginate($limit);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
         return Todo::where('user_id', auth()->id())->findOrFail($id);
    }

    /**
     * @param $validated_data
     *  For adding user_id to record using TodoObserver
     */
    public function save($validated_data)
    {
        Todo::create($validated_data);
    }

    /**
     * @param $id
     * @param array $validated_data
     */
    public function update($id, array $validated_data)
    {
         Todo::where('user_id', auth()->id())->findOrFail($id)->update($validated_data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Todo::where('user_id', auth()->id())->findOrFail($id)->delete();
    }
}
