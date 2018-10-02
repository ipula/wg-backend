<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;
    protected $table='players';
    protected $primaryKey='id';
    protected $dates = ['deleted_at'];

    public function getPlayerImageUrlAttribute($value){
        return config('wgconf.WEB_URL').$value;
    }
    public function teams()
    {
        return $this->belongsToMany('App\Team', 'teams_players','player_id');
    }
}
