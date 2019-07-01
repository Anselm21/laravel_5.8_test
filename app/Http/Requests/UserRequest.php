<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'email' => 'required|string|email|unique:users,email',
            'name' => 'required|string|min:3|max:50',
            'password' => 'required|string',
        ];

        switch ($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                        'name' => 'string|min:3|max:100',
                        'password' => 'string',
                        'email' => 'string|email|unique:users,email,' . $this->id
                    ];
        }
    }
}
