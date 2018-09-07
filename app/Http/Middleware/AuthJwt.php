<?php
/**
 * Created by PhpStorm.
 * User: Ipula Indeewara
 * Date: 3/15/2018
 * Time: 2:35 PM
 */

namespace App\Http\Middleware;

use App\Helpers\APIHelper;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthJwt
{
    public function handle($request, Closure $next) {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if($user->user_is_verify==1){

            }else{
                $result = APIHelper::createAPIResponse(true, 10004, null, null);
                return response()->json($result, 401);
            }

        } catch (TokenExpiredException $e) {
            $result = APIHelper::createAPIResponse(true, 14004, null, null);
            return response()->json($result, 401);
        } catch (TokenInvalidException $e) {
            $result = APIHelper::createAPIResponse(true, 14004, null, null);
            return response()->json($result, 401);
        } catch (JWTException $e) {
            $result = APIHelper::createAPIResponse(true, 14004, null, null);
            return response()->json($result, 401);
        }

        $response =  $next($request);
        return $response;
    }
}