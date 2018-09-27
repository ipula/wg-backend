<?php

namespace App\Http\Controllers\Api;

use App\Helpers\APIHelper;
use App\Http\Requests\ApiRequest\TeamCreate;
use App\Http\Requests\ApiRequest\TeamUpdate;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function createTeam(TeamCreate $request){

        $timestamp = round(microtime(true) * 1000);
        $image=$request->team_image;
        $file_extention = $image->getClientOriginalExtension();
        $new_fileName = $timestamp . rand(111111111, 999999999) . '.' . $file_extention;
        $image->move(public_path() . '/assets/team_images/', $new_fileName); //normal image save...

        $team=new Team();
        $team->team_name=$request->team_name;
        $team->team_type=$request->team_type;
        $team->team_player_name=$request->team_player_name;

        if (file_exists(public_path() . '/assets/team_images/' . $new_fileName)) {
            $team->team_image_url='assets/team_images/'.$new_fileName;
        }
        $team->team_additional_note=$request->team_additional_note;

        if($team->save()){
            $team->games()->attach($request->game_id);
            $result = APIHelper::createAPIResponse(false, null, null, "New Team created");
            return response()->json($result, 201);
        }else{
            $result = APIHelper::createAPIResponse(true, 25001, null, null);
            return response()->json($result, 500);
        }
    }

    public function getTeam(){
        $game=Team::with(['games'])->paginate(10);
        $result = APIHelper::createAPIResponse(false, null, $game, null);
        return response()->json($result, 200);
    }

    public function editTeam($team_id,TeamUpdate $request){

        $team=Team::find($team_id);
//        return response()->json([$request->game_id,$request->old_game_id], 201);
        if($team){
            if($request->team_name){
                $team->team_name=$request->team_name;
            }
            if($request->team_type){
                $team->team_type=$request->team_type;
            }
            if($request->team_additional_note){
                $team->team_additional_note=$request->team_additional_note;
            }
            if($request->team_player_name){
                $team->team_player_name=$request->team_player_name;
            }
            if($request->team_player_name){
                $team->team_player_name=$request->team_player_name;
            }
            if(isset($request->team_image) && $request->team_image!=null){
                $timestamp = round(microtime(true) * 1000);
                $image=$request->team_image;
                $file_extention = $image->getClientOriginalExtension();
                $new_fileName = $timestamp . rand(111111111, 999999999) . '.' . $file_extention;
                $image->move(public_path() . '/assets/game_images/', $new_fileName); //normal image save...

                if (file_exists(public_path() . '/assets/game_images/' . $new_fileName)) {
                    $team->team_image_url='assets/game_images/'.$new_fileName;
                }
            }

            if($team->save()){
                if(count($request->old_game_id)){
                    $team->games()->sync($request->old_game_id);
                }
                    $team->games()->attach($request->game_id);
                $result = APIHelper::createAPIResponse(false, null, null, "Team updated");
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
        $team=Team::with(['games'])->find($team_id);
        if($team){
            $result = APIHelper::createAPIResponse(false, null, $team, null);
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 404);
        }
    }
    public function searchTeam(Request $request){
        $team=Team::where('team_name','LIKE',"%$request->team_name")->get;
        if($team){
            $result = APIHelper::createAPIResponse(false, null, $team, null);
            return response()->json($result, 200);
        }else{
            $result = APIHelper::createAPIResponse(true, 60007, null, null);
            return response()->json($result, 404);
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
            return response()->json($result, 404);
        }
    }
}
