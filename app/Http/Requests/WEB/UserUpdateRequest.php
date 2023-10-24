<?php

namespace App\Http\Requests\WEB;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|email",
            "password" => "nullable|min:8",
            "photo" => "mimes:png,jpg,jpeg|max:2000",
            "phone" => "required",
            "subdistrict_id" => "required|exists:subdistricts,id"
        ];
    }
}
