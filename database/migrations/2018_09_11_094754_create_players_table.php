<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('player_name',200)->nullable(true)->default(null);
            $table->string('player_ign',200)->nullable(true)->default(null);
            $table->tinyInteger('player_gender',false)->nullable(true)->default(null);
            $table->string('player_address',400);
            $table->string('player_mobile',200);
            $table->string('player_additional_note',400)->nullable(true)->default(null);
            $table->string('player_image_url',400)->nullable(true)->default(null);
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
        Schema::dropIfExists('players');
    }
}
