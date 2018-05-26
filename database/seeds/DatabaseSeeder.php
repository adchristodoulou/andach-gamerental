<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
        $this->call(SystemsTableSeeder::class);
        
        if (App::environment('testing')) 
        {
            $this->call(PHPUnitTestSeeder::class);
        }
    }
}
