<?php

namespace App\Http\Requests\WEB;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            "email" => "required",
            "phone" => "required",
            "photo" => "image|max:2048|mimes:png,jpg",
            "address" => "max:255",
            "description" => "max:255",
            "subdistrict_id" => "required|exists:subdistricts,id"
        ];
    }
}
