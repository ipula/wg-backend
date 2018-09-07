<?php
/**
 * Created by PhpStorm.
 * User: Ipula Indeewara
 * Date: 3/15/2018
 * Time: 3:57 PM
 */

namespace App\Helpers;


class APIHelper
{
    public static function createAPIResponse($is_error, $message_code = null, $content = null, $custom_msg=null)
    {
        $result = [];

        if ($is_error) {
            $error_messages = config('wgconf.err_messages');
            $result["success"]= false;
            $result["errors"]["code"] = $message_code;
            $result["errors"]["title"] = $error_messages[$message_code];
            $result["errors"]["detail"] = $custom_msg;
        } else {
            $result["success"]= true;
            $result["data"] = $content;
            if($content==null){
                $result["success"]= true;
                $result["data"]["message"]=$custom_msg;
            }
        }

        return $result;
    }

    public static function errorsResponse($errors)
    {
        $error_data = [];
        foreach ($errors as $x => $x_value) {
            $data['source']['pointer'] = $x;
            foreach ($x_value as $value) {
                if (is_array($value)) {
                    $data['code'] = $value[0];
                    $data['title'] = config('wgconf.err_messages')[$value[0]];
                    $data['detail'] = $value[1];
                } else {
                    $data['code'] = explode("|", $value)[0];
                    $data['title'] = config('wgconf.err_messages')[explode("|", $value)[0]];
                    $data['detail'] = explode("|", $value)[1];
                }
            }
            $error_data[] = $data;
        }
        return ["error" => $error_data];
    }
}