<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Eng Nour Othman
 */
class RoleSeed extends Seeder
{
    // role 1 is super_admin   2 is wasity_manager  3 is sub_branch_owner

    public function run(): void
    {
        DB::table('role')->insert([

            'name' => "super_admin",

        ]);
        DB::table('role')->insert([

            'name' => "wasity_manager",

        ]);
        DB::table('role')->insert([

            'name' => "sub_branch_owner",

        ]);
     
    }
}
