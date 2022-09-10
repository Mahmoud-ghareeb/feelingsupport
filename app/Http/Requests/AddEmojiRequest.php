<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEmojiRequest extends FormRequest
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
            'type_en' => 'required|string|max:255',
            'type_ar' => 'required|string|max:255',
            'category' => 'required|string|max:15',
            'css_class' => 'required|string|max:50',
            'color' => 'required|string|max:20'
        ];
    }
}
