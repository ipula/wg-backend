<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getTeamImageUrlAttribute($value){
        return config('wgconf.WEB_URL').$value;
    }

    public function games()
    {
        return $this->belongsToMany('App\Game', 'games_teams');
    }
    public function players()
    {
        return $this->belongsToMany('App\Player', 'teams_players');
    }
}
