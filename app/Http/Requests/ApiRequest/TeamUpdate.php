<?php

namespace App\Http\Requests\ApiRequest;

use App\Helpers\APIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeamUpdate extends FormRequest
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
            'team_name' =>'nullable|required_without_all:team_type,team_player_name,team_image',
            'team_type' =>'required_without_all:team_name,team_player_name,team_image',
            'team_player_name' =>'nullable|required_without_all:team_type,team_name,team_image',
            'game_id' =>'required',
            'team_image' => 'required_without_all:team_type,team_name,team_player_name|image|mimes:jpg,jpeg,PNG,png|max:5120'
        ];
    }

    public function messages()
    {

        return [
            'team_name.required_without_all'=>[60001,'Team name required'],
            'team_type.required_without_all'=>[60001,'Team type required'],
            'team_image.required_without_all'=>[60001,'Team image field required'],
            'game_id.required'=>[60001,'Game id field required'],
            'team_player_name.required_without_all'=>[60001,'Team player name field required'],
            'team_image.image'=>[50001,'Only images allowed to upload'],
            'team_image.mimes'=>[50001,'Only jpg,jpeg And PNG,png Allowed'],
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
