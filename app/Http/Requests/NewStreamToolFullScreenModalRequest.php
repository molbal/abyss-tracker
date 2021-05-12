<?php

namespace App\Http\Requests;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class NewStreamToolFullScreenModalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return AuthController::isLoggedIn();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
