<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email'
            ];
        }
        if($method == 'update'){
            return [
                //
                'username' => 'required|unique:users,username,'.$this->id.',id',
                'email' => 'required|unique:users,email,'.$this->id.',id',
            ];
        }
    }

    public function messages()
    {
        return[
            'username.required' => __('validation.required',['attribute' => 'Mã sinh viên']),
            'username.unique' => __('validation.unique',['attribute' => 'Mã sinh viên']),
            'email.required' => __('validation.required',['attribute' => 'Địa chỉ Email']),
            'email.unique' => __('validation.unique',['attribute' => 'Địa chỉ Email']),
        ];
    }
}
