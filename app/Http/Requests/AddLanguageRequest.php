<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLanguageRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'abbr' => 'required|string|max:10',
            'active' => 'nullable|in:1,0',
            'direction' => 'required|in:rtl,ltr'
        ];
    }

    public function messages()
    {
        return [
            'required' => "هذا الحقل مطلوب",
            'in' => "القيمة المدخلة غير صحيحة",
            'string' => 'لا بد من إدخال حروف فقط',
            'name.max' => "لا يمكن إدخال أكثر من مائة حرف",
            'abbr.max' => "لا يمكن إدخال أكثر من عشرة حروف",
        ];
    }
}
