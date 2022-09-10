<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeelingRequest extends FormRequest
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
            'feel_id' => 'required|string',
            'reason'  => 'nullable|string',
            'image'   => 'image'
        ];
    }
    
    public function messages()
    {
        return [
            'feel_id.required' => __('messages.you must choose at least one emoji'),
            'image.image'   => __('messages.this file must be an image')
        ];
    }
}
