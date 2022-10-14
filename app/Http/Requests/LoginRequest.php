<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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

            'Email' => 'required',
            'Password' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'Email.required' => 'الايميل مطلوب',

            'Password.required' => 'كلمة المرور مطلوبة',
            // 'Password.min' => 'كلمة المرور يجب ان تكون 8 ارقام على الاقل'


        ];
    }
}
