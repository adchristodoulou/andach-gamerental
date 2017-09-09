<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Action / Adventure',
            'url' => 'action-adventure',
        ]);
        DB::table('categories')->insert([
            'name' => 'Arcade',
            'url' => 'arcade',
        ]);
        DB::table('categories')->insert([
            'name' => 'Fighting',
            'url' => 'fighting',
        ]);
        DB::table('categories')->insert([
            'name' => 'Flight / Aircraft',
            'url' => 'flight',
        ]);
        DB::table('categories')->insert([
            'name' => 'Children and Family Friendly',
            'url' => 'kids',
        ]);
        DB::table('categories')->insert([
            'name' => 'Racing',
            'url' => 'racing',
        ]);
        DB::table('categories')->insert([
            'name' => 'FPS',
            'url' => 'fps',
        ]);
        DB::table('categories')->insert([
            'name' => 'Sport',
            'url' => 'sport',
        ]);
        DB::table('categories')->insert([
            'name' => 'RPG',
            'url' => 'rpg',
        ]);
        DB::table('categories')->insert([
            'name' => 'Music',
            'url' => 'music',
        ]);
    }
}
