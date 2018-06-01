<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveContactRequest extends FormRequest
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
            'name' => [
                'required', 
                'string', 
                'max:255'
            ],

            'last_name' => [
                'required', 
                'string', 
                'max:255'
            ],

            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255',
                Rule::unique('contacts')
                    ->ignore($this->route('contact'))
                    ->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    })
            ],

            'phone' => [
                'required', 
                'string', 
                'max:15',
                Rule::unique('contacts')
                    ->ignore($this->route('contact'))
                    ->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    })
            ],
        ];
    }
}
