<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsFormRequest extends FormRequest
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
            'name' => 'required|max:255|unique:products,name,'.$this->getIdInUrl(),
            'stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required',
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
