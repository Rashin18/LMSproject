<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after:now',
            'max_score' => 'required|numeric|min:1',
        ];
    }
}