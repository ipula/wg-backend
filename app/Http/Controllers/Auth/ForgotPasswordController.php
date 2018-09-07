<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\APIHelper;
use App\Http\Controllers\Controller;
use App\Mail\UserResetPassword;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function get_reset_password_link(Request $request)
    {
        $user = User::where('user_email', '=', $request->email)->first();

        $timestamp = round(microtime(true) * 1000);
        if ($user) {
            $user_verification_code = Str::random(60);
            $token = $user_verification_code . $timestamp;
            DB::table('password_resets')->insert([
                'email' => $user->user_email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
            try{
                Mail::to($user->user_email)->send(new UserResetPassword($user->user_email, $token,config('wgconf.WEB_URL')));
                $result = APIHelper::createAPIResponse(false, null, null, "Password reset request accepted");
                return response()->json($result, 200);
            }catch (\Exception $e){
                $result = APIHelper::createAPIResponse(true, 25004, null, null);
                return response()->json($result, 503);
            }
        } else {
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 422);
        }
    }
}
