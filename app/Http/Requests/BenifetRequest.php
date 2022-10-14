<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BenifetRequest extends FormRequest
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
            'recipient_name' => 'required',
            'id_num' => 'required|numeric',
            'phone' => 'required|numeric',
            'required_amount' => 'required|numeric'


        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.max' => 'الاسم طويل',
            'recipient_name.required' => 'اسم المتبرع مطلوب',
            'id_num.required' => 'الرقم الوطني مطلوب',
            'id_num.numeric' => 'الرقم الوطني يجب ان يكون رقما',
            'phone.required' => 'رقم الهاتف  مطلوب',
            'phone.numeric' => 'رقم الهاتف يجب ان يكون رقما',

            'required_amount.required' => 'كمية التبرع مطلوبة',
            'required_amount.numeric' => 'كمية التبرع يجب ان تكون رقما',
            // 'recipient_name.numeric' => 'كمية التبرع يجب ان تكون رقما',


            // 'reason.required' => 'سبب التبرع مطلوبة',
            // 'blood_id.required' => 'زمرة الدم مطلوبة',


        ];
    }
}
