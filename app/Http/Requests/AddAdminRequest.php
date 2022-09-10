<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAdminRequest extends FormRequest
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
            'user_name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'image' => 'required|image',
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|string'
        ];
    }
}
