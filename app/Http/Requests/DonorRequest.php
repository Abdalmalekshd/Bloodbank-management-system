<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonorRequest extends FormRequest
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
            'phone' => 'required|numeric',
            'amount' => 'required|numeric',
            // 'reason' => 'required',
            // 'blood_id' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.max' => 'الاسم مطلوب',
            'id_num.required' => 'الرقم الوطني مطلوبة',
            'id_num.numeric' => 'الرقم الوطني يجب ان يكون رقما',
            'phone.required' => 'رقم الهاتف  مطلوبة',
            'phone.numeric' => 'رقم الهاتف  يجب ان يكون رقما',
            'amount.required' => 'كمية التبرع مطلوبة',
            'amount.numeric' => 'كمية التبرع يجب ان تكون رقما',

            // 'reason.required' => 'سبب التبرع مطلوبة',
            // 'blood_id.required' => 'زمرة الدم مطلوبة',


        ];
    }
}
