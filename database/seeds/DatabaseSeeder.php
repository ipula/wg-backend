<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user = new User();
        $user->user_first_name = 'ipula';
        $user->user_email = 'ipula@gmail.com';
        $user->user_password = bcrypt('123');
        $user->user_role = 1;
        $user->save();
    }
}
