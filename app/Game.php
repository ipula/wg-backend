<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getGameImageUrlAttribute($value){
        return config('wgconf.WEB_URL').$value;
    }

    public function teams()
    {
        return $this->belongsToMany('App\Teams', 'games_teams');
    }
}
