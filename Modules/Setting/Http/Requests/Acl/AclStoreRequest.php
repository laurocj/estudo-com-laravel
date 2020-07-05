<?php

namespace Modules\Setting\Http\Requests\Acl;

use Illuminate\Foundation\Http\FormRequest;

class AclStoreRequest extends FormRequest
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
     * Para substituir o nome do atributo na messagem de erro.
     */
    public function attributes()
    {
        return [
            'numero' => 'número'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			// 'role_id' => 'required|numeric',
			// 'action_id' => 'required|numeric',
			// 'resource_id' => 'required|numeric',
        ];
    }

    /**
     * Get the messages.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
