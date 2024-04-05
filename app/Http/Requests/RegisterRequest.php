<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:users',
            'title' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
