<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $password = Hash::make('popbox');

        User::create([
            'phone' => '0811990995',
            'name' => 'Candra',
            'password' => $password,
            'remember_token' => str_random(10)
        ]);
    }
}
