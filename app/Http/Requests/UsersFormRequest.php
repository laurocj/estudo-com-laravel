<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersFormRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->getIdInUrl(),
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required'
        ];
    }

    /**
     * Retrieve the id in the url
     *
     * @return int
     */
    private function getIdInUrl() : int
    {
        foreach($this->segments() as $segment) {
            if(is_numeric($segment)){
                return $segment;
            }
        }
        return 0;
    }
}
