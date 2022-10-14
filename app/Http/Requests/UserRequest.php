<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|max:40|unique:users,email',
            'password' => 'required|min:8',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'الايميل مطلوب',
            'email.unique' => ' هذا الايميل مستخدم',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور قصيرة جدا',
        ];
    }
}
