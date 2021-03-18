<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //factory(App\User::class, 50)->create();
        DB::table('users')->insert([
            'name' => "admin",
            'email' => 'isheo@ru-se.com',
            'password' => Hash::make('password'),
        ]);
    }
}
