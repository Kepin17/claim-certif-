<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'jawa@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Lele$ukaUjang!Karena_MerekaJ0mok#27X'),
            ]
        );
    }
}
