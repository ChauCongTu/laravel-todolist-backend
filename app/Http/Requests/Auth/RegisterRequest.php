<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|min:5|unique:users|max:255',
            'password' => 'required|min:6',
            'email' => 'required|email|max:255|unique:users',
            'full_name' => 'required|max:255',
            'date_of_birth' => 'required',
            'gender' => 'required|in:Male,Female,Other',
            'phone_number' => 'required|max:15',
        ];
    }
}
