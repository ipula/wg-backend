<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create('games', function (Blueprint $table) {
        $table->increments('id');
        $table->string('game_name',200);
        $table->string('game_type',100);
        $table->string('game_image_url',200);
        $table->string('game_additional_note',400)->nullable(true)->default(null);
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
