<?php

namespace App\Http\Controllers\Api;

use App\Game;
use App\Helpers\APIHelper;
use App\Http\Requests\ApiRequest\GameCreate;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest\GameUpdate;
use Illuminate\Http\Request;

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
            $result = APIHelper::createAPIResponse(true, 25001, null, null);
            return response()->json($result, 500);
        }
    }

    public function getGame(){
        $game=Game::with(['teams'])->paginate(10);
        $result = APIHelper::createAPIResponse(false, null, $game, null);
        return response()->json($result, 200);
    }

    public function editGame($id,GameUpdate $request){

        $game=Game::find($id);

        if($game){
            if($request->game_name){
                $game->game_name=$request->game_name;
            }
            if($request->game_type){
                $game->game_type=$request->game_type;
            }
            if($request->game_additional_note){
                $game->game_additional_note=$request->game_additional_note;
            }
            if($request->game_image){
                $timestamp = round(microtime(true) * 1000);
                $image=$request->game_image;
                $file_extention = $image->getClientOriginalExtension();
                $new_fileName = $timestamp . rand(111111111, 999999999) . '.' . $file_extention;
                $image->move(public_path() . '/assets/game_images/', $new_fileName); //normal image save...

                if (file_exists(public_path() . '/assets/game_images/' . $new_fileName)) {
                    $game->game_image_url='assets/game_images/'.$new_fileName;
                }
            }

            if($game->save()){
                $result = APIHelper::createAPIResponse(false, null, null, "Game updated");
                return response()->json($result, 201);
            }else{
                $result = APIHelper::createAPIResponse(true, 25001, null, null);
                return response()->json($result, 500);
            }
        }else{
            $result = APIHelper::createAPIResponse(true, 20001, null, null);
            return response()->json($result, 404);
        }
    }

    public function getSingleGame($game_id){
        $game=Game::find($game_id);
        if($game){
            $result = APIHelper::createAPIResponse(false, null, $game, null);
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 404);
        }
    }
    public function searchGame(Request $request){
        $game=Game::where('game_name','LIKE',"%$request->game_name%")->get();
        if($game){
            $result = APIHelper::createAPIResponse(false, null, $game, null);
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 404);
        }
    }
    public function deleteGame($game_id){
        $game=Game::find($game_id);
        if($game){
            $game->deleted_at=now();
            $game->save();
            $result = APIHelper::createAPIResponse(false, null, null, "Game deleted");
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 404);
        }
    }

    public function getAllGames(){
        $game=Game::all();
        if($game){
            $result = APIHelper::createAPIResponse(false, null, $game, null);
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 404);
        }
    }
}
