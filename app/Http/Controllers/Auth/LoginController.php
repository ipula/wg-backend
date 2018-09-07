<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\APIHelper;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\PayloadFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class LoginController extends Controller
{
    public function getLogin(Request $request)
    {
        if (!isset($request->email) || !isset($request->password)) {
            $result = APIHelper::createAPIResponse(true, 50001,null, 'Email and Password field needed');
            return response()->json($result, 401);
        } else {
            $user = User::where('user_email', '=', $request->email)->first();
            if ($user) {
                if($user['user_is_verify']==1){
                    if(Hash::check($request->password, $user->user_password)){

                        $customClaims = ["email" => $request->email, "role" => $user->user_role,"is_verify" => $user->user_is_verify];
                        $payload = JWTFactory::sub($user->user_id)->data($customClaims)->make();
                        $token = JWTAuth::encode($payload);

                        $result=APIHelper::createAPIResponse(false,null,["access_token"=>(string)$token],null);
                        return response()->json($result, 201);
                    }else{
                        $result = APIHelper::createAPIResponse(true, 14001,null, 'Email or password incorrect');
                        return response()->json($result, 401);
                    }
                }else{
                    $result = APIHelper::createAPIResponse(true, 10004,null, 'User not verify');
                    return response()->json($result, 401);
                }
            } else {
                $result = APIHelper::createAPIResponse(true, 14001, null,'Email or password incorrect');
                return response()->json(["result" => $result], 401);
            }

        }

    }
}
