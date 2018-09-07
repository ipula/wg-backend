<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id')->unsigned()->nullable(false);
            $table->string('user_first_name',100)->default(null)->nullable();
            $table->string('user_last_name',100)->default(null)->nullable();
            $table->string('user_display_name',100)->default(null)->nullable();
            $table->string('user_email')->unique();
            $table->string('user_password',450)->default(null)->nullable();
            $table->string('user_mobile',450)->default(null)->nullable();
            $table->date('user_date_of_birth')->default(null)->nullable();
            $table->string('user_verification_code',450)->default(null)->nullable();
            $table->tinyInteger('user_is_verify',false)->default(0)->nullable();
            $table->tinyInteger('user_role',false)->default(2)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
