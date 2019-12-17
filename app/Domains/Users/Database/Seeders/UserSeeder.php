<?php

namespace App\Domains\Users\Database\Seeders;

use App\Domains\Users\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        User::create([
    		'name'  	=> 'Bruno Neves',
    		'email' 	=> 'brunu.neves@gmail.com',
    		'password' 	=> bcrypt('admin'),
        ]);

        factory(User::class)
            ->times(10)
            ->create();
    }
}
