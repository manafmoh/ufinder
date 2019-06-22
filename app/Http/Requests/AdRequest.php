<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
            'title' => 'required|min:3|max:150|not_in:null',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'amount' => 'required|not_in:0',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.not_in' => 'Title is required',
            'category_id.integer' => 'Category Required',
            'subcategory_id.integer' => 'Sub Category Required',
            'amount.not_in' => 'Amount is required',
        ];
    }
}
