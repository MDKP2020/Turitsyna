<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'educ_form_id' => 'required',
            'lvl_education_id' => 'required',
            'study_year_id' => 'required',
            'course' => 'required'
        ];
    }
}
