<?php

namespace App\Http\Requests\Customer;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('user');
        return [
            'email' => [
                'required',
                'email',
                'unique:customers,email,'.$id.'id'
            ],
            'name' => 'required',
            'location' => 'required',
            'dob' => 'required',
            'current_timezone' => 'required',
        ];
    }
}
