<?php

namespace App\Http\Requests\ApiRequest;

use App\Helpers\APIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeamCreate extends FormRequest
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
            'team_name' =>'required|nullable',
            'team_type' =>'required',
            'team_player_name' =>'required|nullable',
            'team_image' => 'required|image|mimes:jpg,jpeg,PNG,png|max:5120'
        ];
    }

    public function messages()
    {

        return [
            'team_name.required'=>[60001,'Team name required'],
            'team_type.required'=>[60001,'Team type required'],
            'team_player_name.required'=>[60001,'Player name required'],
            'team_image.required'=>[60001,'Team image field required'],
            'team_image.image'=>[50001,'Only images allowed to upload'],
            'team_image.mimes'=>[50001,'Only jpg,jpeg And PNG,png allowed'],
            'team_image.max'=>[60008,'']

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $message=APIHelper::errorsResponse($errors);

        throw new HttpResponseException(response()->json($message,JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
