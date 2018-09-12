<?php

namespace App\Http\Requests\ApiRequest;

use App\Helpers\APIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlayerUpdate extends FormRequest
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
            'player_name' =>'required_without_all:player_ign,player_mobile,player_address,team_id,player_image',
            'player_ign' =>'required_without_all:player_name,player_mobile,player_address,team_id,player_image',
            'player_mobile' =>'required_without_all:player_name,player_ign,player_address,team_id,player_image',
            'player_address' =>'required_without_all:player_name,player_mobile,player_ign,team_id,player_image',
            'team_id' =>'required_without_all:player_name,player_mobile,player_address,player_ign,player_image',
            'player_image' => 'required_without_all:player_name,player_mobile,player_address,team_id,player_ign|image|mimes:jpg,jpeg,PNG,png|max:5120'
        ];
    }

    public function messages()
    {

        return [
            'player_name.required_without_all'=>[60001,'Player name required'],
            'player_ign.required_without_all'=>[60001,'Player IGN required'],
            'player_mobile.required_without_all'=>[60001,'Player mobile required'],
            'player_address.required_without_all'=>[60001,'Player address required'],
            'player_image.required_without_all'=>[60001,'Player image field required'],
            'team_id.required'=>[60001,'Team id field required'],
            'player_image.image'=>[50001,'Only images allowed to upload'],
            'player_image.mimes'=>[50001,'Only jpg,jpeg And PNG,png Allowed'],
            'player_image.max'=>[60008,'']

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $message=APIHelper::errorsResponse($errors);

        throw new HttpResponseException(response()->json($message,JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
