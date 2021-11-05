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
        return Todo::orderBy('status')->paginate($limit);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
         return Todo::findOrFail($id);
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
         Todo::findOrFail($id)->update($validated_data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Todo::findOrFail($id)->delete();
    }
}
