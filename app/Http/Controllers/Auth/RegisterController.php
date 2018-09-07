<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\APIHelper;
use App\Http\Requests\ApiRequest\UserCreate;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function store(UserCreate $request)
    {
        $user = new User();
        $user->user_first_name = $request->first_name;
        $user->user_last_name = $request->last_name;
        $user->user_email = $request->email;
        $user->user_password = bcrypt($request->password);
        $user->user_date_of_birth = $request->birthday;
        $user->user_mobile = $request->phone_number;
//        $user->user_gender = $request->gender;
        $user->user_verification_code = Str::random(60);
        $user->user_role = 2;//role=1 for admins
        if ($user->save()) {
//            $customClaims = ["email" => $request->email, "role" => $user->user_role, "is_verify" => $user->user_is_verify];
//            $payload = JWTFactory::sub($user->user_id)->data($customClaims)->make();
//            $token = JWTAuth::encode($payload);

            //verification mail...................
//            Mail::to($user->user_email)->send(new UserVerifyMail($user->user_email, $user->user_verification_code, $user->user_id,config('shayInt.WEB_URL')));

            $result = APIHelper::createAPIResponse(false, null, null, "User registration success");
            return response()->json($result, 201);
        } else {
            $result = APIHelper::createAPIResponse(true, null, null, "Internal Server Error");
            return response()->json($result, 500);
        }
    }
}
