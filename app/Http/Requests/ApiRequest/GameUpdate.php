<?php

namespace App\Http\Requests\ApiRequest;

use App\Helpers\APIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GameUpdate extends FormRequest
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
            'game_name' =>'required_without_all:game_type,game_image',
            'game_type' =>'required_without_all:game_image,game_name',
            'game_image' => 'required_without_all:game_type,game_name|image|mimes:jpg,jpeg,PNG,png|max:5120'
        ];
    }

    public function messages()
    {

        return [
            'game_name.required_without_all'=>[60001,'Game Name Required'],
            'game_type.required_without_all'=>[60001,'Game Type Required'],
            'game_image.required_without_all'=>[60001,'game_image field required'],
            'game_image.image'=>[50001,'Only images allowed to upload'],
            'game_image.mimes'=>[50001,'Only jpg,jpeg And PNG,png Allowed'],
            'game_image.max'=>[60008,'']

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $message=APIHelper::errorsResponse($errors);

        throw new HttpResponseException(response()->json($message,JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
