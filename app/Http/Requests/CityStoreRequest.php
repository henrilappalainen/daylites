<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityStoreRequest extends FormRequest
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
      if(request()->isMethod('post')) {
        return [
            'name' => 'required|string|max:258',
            'latitude' => 'required|string|max:258'
        ];
      } else {
        return [
            'name' => 'required|string|max:258',
            'latitude' => 'nullable|string|max:258',
        ];
      }      
    }
}
