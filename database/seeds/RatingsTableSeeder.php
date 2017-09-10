.0<?php

use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ratings')->insert([
            'name' => '3+',
            'minimum_age' => 3,
        ]);
        DB::table('ratings')->insert([
            'name' => '7+',
            'minimum_age' => 7,
        ]);
        DB::table('ratings')->insert([
            'name' => '12+',
            'minimum_age' => 12,
        ]);
        DB::table('ratings')->insert([
            'name' => '16+',
            'minimum_age' => 16,
        ]);
        DB::table('ratings')->insert([
            'name' => '18+',
            'minimum_age' => 18,
        ]);
    }
}
