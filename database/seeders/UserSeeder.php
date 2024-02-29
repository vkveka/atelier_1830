<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'firstname' => 'administrateur',
            'lastname' => 'admin',
            'password' => Hash::make('Azerty99@'),
            'email' => 'admin@admin.fr',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => 1
        ]);

        User::create([
            'firstname' => 'utilisateur',
            'lastname' => 'util',
            'password' => Hash::make('Azerty99@'),
            'email' => 'user@user.fr',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => 2
        ]);


        \App\Models\User::factory(8)->create();
    }
}
