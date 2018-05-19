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
        DB::table('contacts')->insert([
            'user_id' => 2,
            'category_id' => 1,
            'title' => 'CONTACT TITLE',
            'full_text' => 'CONTACT FULLTEXT',
        ]);

        DB::table('contacts')->insert([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'CONTACT TITLE',
            'full_text' => 'CONTACT FULLTEXT',
        ]);

        DB::table('contacts_attachments')->insert([
            'contact_id' => 1,
            'slug' => 'test-attachment',
            'extension' => 'pdf',
            'filename' => 'test',
            'created_at' => '2018-01-01 00:00:00',
        ]);

        DB::table('contacts_categories')->insert([
            'name' => 'TEST CONTACT CATEGORY',
        ]);

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
            'system_id' => 4919,
            'num_in_stock' => 0,
            'num_available' => 0,
        ]);

        DB::table('games')->insert([
            'name' => 'TEST GAME XboxOne 2',
            'slug' => 'test-game-xboxone-2',
            'system_id' => 4920,
            'num_in_stock' => 2,
            'num_available' => 2,
        ]);

        DB::table('games')->insert([
            'name' => 'TEST GAME XboxOne 3',
            'slug' => 'test-game-xboxone-3',
            'system_id' => 4920,
            'num_in_stock' => 1,
            'num_available' => 1,
        ]);

        DB::table('games')->insert([
            'name' => 'TEST GAME XboxOne 4',
            'slug' => 'test-game-xboxone-4',
            'system_id' => 4920,
            'num_in_stock' => 2,
            'num_available' => 2,
        ]);

        DB::table('games')->insert([
            'name' => 'TEST GAME PS4 2',
            'slug' => 'test-game-ps4-2',
            'system_id' => 4919,
            'num_in_stock' => 0,
            'num_available' => 0,
        ]);

        DB::table('games')->insert([
            'name' => 'TEST GAME PS4 3',
            'slug' => 'test-game-ps4-3',
            'system_id' => 4919,
            'num_in_stock' => 0,
            'num_available' => 0,
        ]);

        DB::table('games')->insert([
            'name' => 'TEST GAME PS4 4',
            'slug' => 'test-game-ps4-4',
            'system_id' => 4919,
            'num_in_stock' => 0,
            'num_available' => 0,
        ]);

        DB::table('pages')->insert([
            'body' => 'TEST BODY',
            'name' => 'TEST NAME',
            'h1' => 'TEST H1',
            'html_title' => 'TEST HTMLTITLE',
            'meta_description' => 'TEST METADESCRIPTION',
            'slug' => 'test-page',
            'is_commentable' => 1,
        ]);

        DB::table('pages')->insert([
            'body' => 'TEST SECOND BODY',
            'name' => 'TEST SECOND NAME',
            'h1' => 'TEST SECOND H1',
            'html_title' => 'TEST SECOND HTMLTITLE',
            'meta_description' => 'TEST SECOND METADESCRIPTION',
            'slug' => 'test-second-page',
        ]);

        DB::table('plans')->insert([
            'name' => 'TEST PLAN 1PERMONTH',
            'is_visible' => 1,
            'max_games_per_month' => 1,
            'max_games_simultaneously' => 1,
            'is_priority' => 0,
            'slug' => 'test-plan-1permonth',
            'braintree_plan' => 'test-braintree-1permonth',
            'cost' => 1,
        ]);

        DB::table('plans')->insert([
            'name' => 'TEST PLAN 1UNLIMITED',
            'is_visible' => 1,
            'max_games_per_month' => 99,
            'max_games_simultaneously' => 1,
            'is_priority' => 0,
            'slug' => 'test-plan-1unlimited',
            'braintree_plan' => 'test-braintree-1unlimited',
            'cost' => 2,
        ]);

        DB::table('plans')->insert([
            'name' => 'TEST PLAN 2PRIORITY',
            'is_visible' => 1,
            'max_games_per_month' => 99,
            'max_games_simultaneously' => 2,
            'is_priority' => 1,
            'slug' => 'test-plan-2priority',
            'braintree_plan' => 'test-braintree-2priority',
            'cost' => 3,
        ]);

        DB::table('plans')->insert([
            'name' => 'TEST PLAN 3UNLIMITED',
            'is_visible' => 1,
            'max_games_per_month' => 99,
            'max_games_simultaneously' => 3,
            'slug' => 'test-plan-3unlimited',
            'braintree_plan' => 'test-braintree-3unlimited',
            'cost' => 4,
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

        DB::table('products_categories')->insert([
            'parent_id' => 0,
            'name' => 'TEST HEAD CATEGORY',
            'slug' => 'test-head-category',
        ]);

        DB::table('products_categories_link')->insert([
            'product_id' => 1,
            'category_id' => 1,
        ]);

        DB::table('retirement_reasons')->insert([
            'id' => 1,
            'name' => 'Test Retirement Reason',
        ]);

        DB::table('stock')->insert(['game_id' => 1, 'currently_in_stock' => 1]);
        DB::table('stock')->insert(['game_id' => 3, 'currently_in_stock' => 1]);
        DB::table('stock')->insert(['game_id' => 3, 'currently_in_stock' => 1]);
        DB::table('stock')->insert(['game_id' => 4, 'currently_in_stock' => 1]);
        DB::table('stock')->insert(['game_id' => 5, 'currently_in_stock' => 1]);
        DB::table('stock')->insert(['game_id' => 5, 'currently_in_stock' => 1]);

        DB::table('subscriptions')->insert([
            'user_id' => 1,
            'name' => 'main',
            'braintree_id' => '123456',
            'braintree_plan' => 'test-braintree-1permonth',
            'quantity' => 1,
            'created_at' => '2018-01-01',
            'updated_at' => '2018-01-01',
        ]);

        DB::table('subscriptions')->insert([
            'user_id' => 2,
            'name' => 'main',
            'braintree_id' => 'abcdef',
            'braintree_plan' => 'test-braintree-2priority',
            'quantity' => 1,
            'created_at' => '2018-01-01',
            'updated_at' => '2018-01-01',
        ]);

        DB::table('users')->insert([
        	'id' => 1,
        	'name' => 'Admin User',
        	'email' => 'admin@example.com',
        	'is_admin' => 1,
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
