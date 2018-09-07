<?php

namespace App\Http\Requests\ApiRequest;

use App\Helpers\APIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserCreate extends FormRequest
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

    public function rules()
    {
        return [
            'first_name' =>'required',
            'last_name' =>'required',
            'email' =>'required|unique:users,user_email',
            'phone_number' =>'required',
            'password' =>'required|min:6' ,
        ];
    }

    public function messages()
    {

        return [
            'first_name.required'=>[60001,'First Name Required'],
            'email.required'=>[60001,'Email Required'],
            'email.unique'=>[60002,'Email already taken'],
            'phone_number.required'=>[60001,'Phone number Required'],
            'password.required'=>[60001,'Password Needed'],
            'password.min'=>'60004|At least minimum 6 characters need',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $message=APIHelper::errorsResponse($errors);

        throw new HttpResponseException(response()->json($message,JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
