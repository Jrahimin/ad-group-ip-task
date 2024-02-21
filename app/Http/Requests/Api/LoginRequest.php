<?php

namespace App\Http\Requests\Api;

use App\Http\Traits\ValidationResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use ValidationResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }
}
