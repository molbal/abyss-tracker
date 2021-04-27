<?php

namespace App\Http\Requests;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewStreamToolDailyLinkRequest extends FormRequest
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
            'width' => ['regex:/[0-9]{2,4}px/i'],
            'height' => ['regex:/[0-9]{2,4}px/i'],
            'align' => [Rule::in(['left', 'center', 'right', 'justify'])],
            'fontSize' => ['regex:/[0-9]{1,3}px/i'],
            'fontColor' => ['regex:/#[0-9a-fA-F]{3,6}/i'],
        ];
    }
}
