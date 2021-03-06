<?php

namespace Modules\Setting\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuUpdateRequest extends FormRequest
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
			'name' => 'required|string|max:255',
			'route' => 'required|string|max:255',
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
