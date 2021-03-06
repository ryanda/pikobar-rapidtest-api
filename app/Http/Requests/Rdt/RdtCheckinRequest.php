<?php

namespace App\Http\Requests\Rdt;

use Illuminate\Foundation\Http\FormRequest;

class RdtCheckinRequest extends FormRequest
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
            'registration_code' => ['required'],
            'lab_code_sample' => ['required'],
            'location' => ['sometimes', 'required'],
        ];
    }
}
