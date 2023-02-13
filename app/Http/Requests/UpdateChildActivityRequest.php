<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChildActivityRequest extends FormRequest
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
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ];
    }

    public function messages()
    {
        return[
            'end_time.after' => 'Vui lòng chọn thời gian hợp lệ để cập nhật hoạt động.'
        ];
    }
}
