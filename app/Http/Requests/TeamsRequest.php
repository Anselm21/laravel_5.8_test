<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamsRequest extends FormRequest
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
            'owner_id' => 'integer|exists:users,id',
            'title' => 'required|string|min:3|max:50|unique:teams,title'
        ];
        switch ($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                    'owner_id' => 'integer|exists:users,id',
                    'title' => 'string|min:3|max:50|unique:teams,title,' . $this->id
                ];
        }
    }
}
