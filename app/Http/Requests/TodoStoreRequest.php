<?php

namespace App\Http\Requests;

use App\Models\Todo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TodoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $statuses = Todo::$todo_statuses;

        return [
            'title' => ['required', 'string', 'between:2,20'],
            'description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in($statuses)]
        ];
    }
}
