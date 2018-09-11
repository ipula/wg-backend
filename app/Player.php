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

//    public function getGameImageUrlAttribute($value){
//        return config('wgconf.WEB_URL').$value;
//    }
    public function teams()
    {
        return $this->belongsToMany('App\Team', 'games_teams');
    }
}
