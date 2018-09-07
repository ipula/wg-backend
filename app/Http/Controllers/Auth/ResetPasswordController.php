<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\APIHelper;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function get_reset_password_user($token)
    {
        $user = DB::table('password_resets')->where('token', $token)->first();
        if ($user) {
            $result = APIHelper::createAPIResponse(false, null, ["email" => $user->email, "token" => $token],null);
            return response()->json($result, 200);
        } else {
            $result = APIHelper::createAPIResponse(true, 60009, null,null);
            return response()->json($result, 404);
        }
    }

    public function do_reset_password(Request $request, $token)
    {
        $user_pwd_reset = DB::table('password_resets')->where('token', $token)->first();
        if ($user_pwd_reset) {
            $user = User::where('user_email', $request->email)->first();

            if ($user) {
                $user->user_password =  bcrypt($request->password);
                $user->save();

                $timestamp = round(microtime(true) * 1000);
                $user_verification_code = Str::random(60);

                DB::table('password_resets')->where('token', '=', $token)->update([
                    'token' => $user_verification_code . $timestamp,
                    'created_at' => Carbon::now()
                ]);

                $result = APIHelper::createAPIResponse(false, null, null,"Password reset success");
                return response()->json($result, 200);
            } else {
                $result = APIHelper::createAPIResponse(true, 60009, null,null);
                return response()->json($result, 404);
            }
        } else {
            $result = APIHelper::createAPIResponse(true, 60009, null,null);
            return response()->json($result, 404);
        }

    }
}
