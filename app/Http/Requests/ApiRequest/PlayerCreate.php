<?php

namespace App\Http\Requests\ApiRequest;

use App\Helpers\APIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlayerCreate extends FormRequest
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
            'player_name' =>'required|unique:players,player_name',
            'player_ign' =>'required|unique:players,player_ign',
            'player_mobile' =>'required',
            'player_address' =>'required',
            'team_id' =>'required',
            'player_image' =>'nullable',
            'player_image.' => 'image|mimes:jpg,jpeg,PNG,png|max:5120'
        ];
    }

    public function messages()
    {

        return [
            'player_name.required'=>[60001,'Player name required'],
            'player_name.unique'=>[60002,'Player name already taken'],
            'player_ign.required'=>[60001,'Player IGN required'],
            'player_ign.unique'=>[60002,'Player IGN already taken'],
            'player_mobile.required'=>[60001,'Player mobile required'],
            'player_address.required'=>[60001,'Player address required'],
            'team_id.required'=>[60001,'Team id required'],
            'player_image_url.required'=>[60001,'Player image field required'],
            'player_image_url.image'=>[50001,'Only images allowed to upload'],
            'player_image_url.mimes'=>[50001,'Only jpg,jpeg And PNG,png allowed'],
            'player_image_url.max'=>[60008,'']

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $message=APIHelper::errorsResponse($errors);

        throw new HttpResponseException(response()->json($message,JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
