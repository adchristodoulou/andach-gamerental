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
            'name' => 'TEST GAME IN STOCK',
            'slug' => 'test-game-in-stock',
            'system_id' => 4920,
            'num_in_stock' => 1,
            'num_available' => 1,
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

        DB::table('products')->insert([
            'id' => 1,
            'slug' => 'test-first-product',
            'price' => 999,
            'name' => 'Name of the First Product',
            'snippet' => 'Snippet of the First Product',
            'full_text' => 'Full Text of the First Product',
            'is_vatable' => 1,
            'num_in_stock' => 0,
        ]);

        DB::table('retirement_reasons')->insert([
            'id' => 1,
            'name' => 'Test Retirement Reason',
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
