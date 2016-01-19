<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Joe Skinner',
            'email' => 'joe.skinner@progyny.com',
            'password' => bcrypt('F#rtility47'),
        ]);
    }
}