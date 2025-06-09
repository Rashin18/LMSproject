<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'due_date' => 'sometimes|date|after:now',
            'max_score' => 'sometimes|numeric|min:1',
            'status' => 'sometimes|in:pending,graded,archived',
        ];
    }
}