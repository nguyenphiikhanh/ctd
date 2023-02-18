<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StudyYearRequest extends FormRequest
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
        $method = $this->route()->getActionMethod();
        if($method == 'store'){
            return [
                //
                'year_name' => 'required|unique:study_years,year_name'
            ];
        }
        if($method == 'update'){
            return [
                //
                'year_name' => 'required|unique:study_years,year_name,'.$this->id.',id'
            ];
        }
    }

    public function messages()
    {
        return[
            'year_name.required' => __('validation.required',['attribute' => 'Tên năm học']),
            'year_name.unique' => __('validation.unique',['attribute' => 'Năm học'])
        ];
    }
}
