<?php

namespace App\Http\Requests\WEB;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocterRequest extends FormRequest
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
            "phone" => "required",
            "photo" => "required|image|max:2048|mimes:png,jpg",
            "address" => "required|max:255",
            "category_docter_id" => "required|exists:category_docters,id",
            "description" => "required|max:255",
            "subdistrict_id" => "required|exists:subdistricts,id"
        ];
    }
}
