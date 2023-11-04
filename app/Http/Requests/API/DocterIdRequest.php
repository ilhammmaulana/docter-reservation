<?php

namespace App\Http\Requests\API;

use App\Traits\ResponseAPI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DocterIdRequest extends FormRequest
{
    use ResponseAPI;
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
            "docter_id" => "required|exists:docters,id"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        if ($errors->has('docter_id')) {
            $docterError = $errors->get('docter_id');

            if (in_array('The selected docter id is invalid.', $docterError)) {
                throw new HttpResponseException($this->requestNotFound('Docter not found!'));
            }
        }
        throw new HttpResponseException($this->requestValidation(formatErrorValidatioon($validator->errors()), 'Failed!'));
    }
}
