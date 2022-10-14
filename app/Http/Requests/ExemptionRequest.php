<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExemptionRequest extends FormRequest
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

            'name' => 'required|max:60',
            'id_num' => 'required|numeric',
            'phone' => 'required|numeric'


        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.max' => 'الاسم طويل',
            'id_num.required' => 'الرقم الوطني مطلوب',
            'id_num.numeric' => 'الرقم الوطني يجب ان يكون رقما',
            'phone.required' => 'رقم الهاتف  مطلوب',
            'phone.numeric' => 'رقم الهاتف يجب ان يكون رقما'


        ];
    }
}
