<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fit_id' => 'required|exists:fits,ID',
            'question_id' => 'required|exists:fit_questions,id',
            'text' => 'required|max:1000'
        ];
    }
}
