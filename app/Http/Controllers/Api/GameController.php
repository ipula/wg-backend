<?php

namespace App\Http\Controllers\Api;

use App\Game;
use App\Helpers\APIHelper;
use App\Http\Requests\ApiRequest\GameCreate;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function createGame(GameCreate $request){

        $timestamp = round(microtime(true) * 1000);
        $image=$request->game_image;
        $file_extention = $image->getClientOriginalExtension();
        $new_fileName = $timestamp . rand(111111111, 999999999) . '.' . $file_extention;
        $image->move(public_path() . '/assets/game_images/', $new_fileName); //normal image save...

        $game=new Game();
        $game->game_name=$request->game_name;
        $game->game_type=$request->game_type;

        if (file_exists(public_path() . '/assets/game_images/' . $new_fileName)) {
            $game->game_image_url='assets/game_images/'.$new_fileName;
        }
        $game->game_additional_note=$request->game_additional_note;

        if($game->save()){
            $result = APIHelper::createAPIResponse(false, null, null, "New game created");
            return response()->json($result, 201);
        }else{
            $result = APIHelper::createAPIResponse(false, 25001, null, null);
            return response()->json($result, 500);
        }
    }

    public function getGame(){
        $game=Game::paginate(10);
        $result = APIHelper::createAPIResponse(false, null, $game, null);
        return response()->json($result, 200);
    }
}
