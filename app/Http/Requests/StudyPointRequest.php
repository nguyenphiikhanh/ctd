<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyPointRequest extends FormRequest
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
            //
            'file' => 'required|mimes:xlsx,xls,xlsm|max:10240',
        ];
    }

    public function messages()
    {
        return[
            'file.required' => __('validation.required',['attribute' => 'File điểm']),
            'file.mimes' => __('validation.mimes',['attribute' => 'Excel']),
            'file.max' => __('validation.max.file',['max' => '10']),
        ];
    }
}
