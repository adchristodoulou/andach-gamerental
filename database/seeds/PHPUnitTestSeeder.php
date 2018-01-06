<?php

use Illuminate\Database\Seeder;

class PHPUnitTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            'name' => 'TEST GAME',
            'slug' => 'test-game',
            'system_id' => 4920,
            'num_in_stock' => 1,
        ]);

        DB::table('games')->insert([
            'name' => 'TEST GAME OUT OF STOCK',
            'slug' => 'test-game-out-of-stock',
            'system_id' => 4920,
        ]);

        DB::table('pages')->insert([
            'body' => 'TEST BODY',
            'name' => 'TEST NAME',
            'h1' => 'TEST H1',
            'html_title' => 'TEST HTMLTITLE',
            'meta_description' => 'TEST METADESCRIPTION',
            'slug' => 'test-page',
        ]);

        DB::table('users')->insert([
        	'id' => 1,
        	'name' => 'Admin User',
        	'email' => 'admin@example.com',
        	'password' =>  bcrypt('adminpass'),
        ]);

        DB::table('users')->insert([
        	'id' => 2,
        	'name' => 'Normal User',
        	'email' => 'user@example.com',
        	'password' =>  bcrypt('userpass'),
        ]);
    }
}
