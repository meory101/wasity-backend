<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeed extends Seeder
{

    /**
     * Eng Nour Othman
     */
    public function run(): void
    {
        DB::table('Vehicle')->insert([

            'name' => "Cycle",

        ]);
        DB::table('Vehicle')->insert([

            'name' => "Regular Car
",

        ]);
        DB::table('Vehicle')->insert([

            'name' => "Passenger Car",

        ]);
        DB::table('Vehicle')->insert([

            'name' => "Cargo Van",

        ]);
        DB::table('Vehicle')->insert([

            'name' => "Truk",

        ]);
    }
}
