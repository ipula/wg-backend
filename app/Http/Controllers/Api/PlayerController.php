<?php

namespace App\Http\Controllers\Api;

use App\Helpers\APIHelper;
use App\Http\Requests\ApiRequest\PlayerCreate;
use App\Http\Requests\ApiRequest\PlayerUpdate;
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
            $result = APIHelper::createAPIResponse(true, 25001, null, null);
            return response()->json($result, 500);
        }
    }

    public function getPlayer(){
        $players=Player::paginate(10);
        $result = APIHelper::createAPIResponse(false, null, $players, null);
        return response()->json($result, 200);
    }

    public function editPlayer($player_id,$old_team_id,PlayerUpdate $request){

        $player=Player::find($player_id);

        if($player){
            if($request->player_name){
                $player->player_name=$request->player_name;
            }
            if($request->player_gender){
                $player->player_gender=$request->player_gender;
            }
            if($request->team_additional_note){
                $player->team_additional_note=$request->team_additional_note;
            }
            if($request->player_address){
                $player->player_address=$request->player_address;
            }
            if($request->player_ign){
                $player->player_ign=$request->player_ign;
            }
            if($request->player_mobile){
                $player->player_mobile=$request->player_mobile;
            }
            if($request->player_additional_note){
                $player->player_additional_note=$request->player_additional_note;
            }
            if(isset($request->player_image) && $request->player_image!=null){
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
                if($old_team_id!=$request->team_id){
                    $player->teams()->sync([$old_team_id]);
                    $player->teams()->attach([$request->team_id]);
                }
                $result = APIHelper::createAPIResponse(false, null, null, "Player updated");
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

    public function getSingleTeam($team_id){
        $team=Team::find($team_id);
        if($team){
            $result = APIHelper::createAPIResponse(false, null, $team, null);
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 422);
        }
    }
    public function deleteTeam($team_id){
        $team=Team::find($team_id);
        if($team){
            $team->deleted_at=now();
            $team->save();
            $result = APIHelper::createAPIResponse(false, null, null, "Team deleted");
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 422);
        }
    }
}
