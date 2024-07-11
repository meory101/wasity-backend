<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeed extends Seeder
{
    /**
     * Eng Nour Othman
     */
    public function run(): void
    {
        DB::table('manager')->insert([

            'email' => "superadmin@gmail.com",
            'password' => Hash::make(12345678),
            'role_id' => 3

        ]);
    }
}
