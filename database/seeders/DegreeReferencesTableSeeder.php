<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DegreeReferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('degree_references')->insert([
            'name'      => 1,
            'reference' => 1,
            'period'    => 1,
            'is_active' => 1
        ]);

        DB::table('degree_references')->insert([
            'name'      => 2,
            'reference' => 2,
            'period'    => 2,
            'is_active' => 1
        ]);

        DB::table('degree_references')->insert([
            'name'      => 3,
            'reference' => 3,
            'period'    => 1,
            'is_active' => 1
        ]);

        DB::table('degree_references')->insert([
            'name'      => 4,
            'reference' => 4,
            'period'    => 2,
            'is_active' => 1
        ]);

        DB::table('degree_references')->insert([
            'name'      => 5,
            'reference' => 5,
            'period'    => 1,
            'is_active' => 1
        ]);

        DB::table('degree_references')->insert([
            'name'      => 6,
            'reference' => 6,
            'period'    => 2,
            'is_active' => 1
        ]);

    }
}
