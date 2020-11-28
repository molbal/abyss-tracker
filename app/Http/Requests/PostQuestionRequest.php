<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fit_id' => 'required|exists:fits,id',
            'question' => 'required|max:1000'
        ];
    }
}
