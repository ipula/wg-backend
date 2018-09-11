<?php

namespace App\Http\Controllers\Api;

use App\Helpers\APIHelper;
use App\Http\Requests\ApiRequest\PlayerCreate;
use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public function createPlayer(PlayerCreate $request){

        $player=new Player();
        $player->player_name=$request->player_name;
        $player->player_gender=$request->player_gender;
        $player->player_address=$request->player_address;
        $player->player_ign=$request->player_ign;
        $player->player_mobile=$request->player_mobile;
        $player->player_additional_note=$request->player_additional_note;

        if($request->player_image){
            $timestamp = round(microtime(true) * 1000);
            $image=$request->player_image;
            $file_extention = $image->getClientOriginalExtension();
            $new_fileName = $timestamp . rand(111111111, 999999999) . '.' . $file_extention;
            $image->move(public_path() . '/assets/player_images/', $new_fileName); //normal image save...
            if (file_exists(public_path() . '/assets/player_images/' . $new_fileName)) {
                $player->player_image_url='assets/player_images/'.$new_fileName;
            }
        }

        if($player->save()){
            $player->teams()->attach([$request->team_id]);
            $result = APIHelper::createAPIResponse(false, null, null, "New player created");
            return response()->json($result, 201);
        }else{
            $result = APIHelper::createAPIResponse(false, 25001, null, null);
            return response()->json($result, 500);
        }
    }

    public function getTeam(){
        $game=Team::paginate(10);
        $result = APIHelper::createAPIResponse(false, null, $game, null);
        return response()->json($result, 200);
    }
}
