<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User as ModelUser;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin1234'),
            ],
            [
                'name' => 'Dinkes',
                'email' => 'dinkes@gmail.com',
                'role' => 'dinkes',
                'password' => Hash::make('dinkes1234'),
            ],
            [
                'name' => 'Bidan',
                'email' => 'bidan@gmail.com',
                'role' => 'bidan',
                'password' => Hash::make('bidan1234'),
            ],
        ];

        ModelUser::insert($users);
    }
}
