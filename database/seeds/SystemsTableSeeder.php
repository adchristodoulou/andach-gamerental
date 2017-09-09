<?php

use Illuminate\Database\Seeder;

class SystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('systems')->insert([
            'name' => 'Xbox One',
            'url' => 'xbox-one',
        ]);
        DB::table('systems')->insert([
            'name' => 'Xbox 360',
            'url' => 'xbox-360',
        ]);
        DB::table('systems')->insert([
            'name' => 'Playstation 4',
            'url' => 'ps4',
        ]);
        DB::table('systems')->insert([
            'name' => 'Playstation 3',
            'url' => 'ps3',
        ]);
        DB::table('systems')->insert([
            'name' => 'Wii U',
            'url' => 'wii-u',
        ]);
        DB::table('systems')->insert([
            'name' => 'Wii',
            'url' => 'wii',
        ]);
        DB::table('systems')->insert([
            'name' => 'DS',
            'url' => 'ds',
        ]);
        DB::table('systems')->insert([
            'name' => '3DS',
            'url' => '3ds',
        ]);
        DB::table('systems')->insert([
            'name' => 'PS Vita',
            'url' => 'vita',
        ]);
        DB::table('systems')->insert([
            'name' => 'PSP',
            'url' => 'psp',
        ]);
        DB::table('systems')->insert([
            'name' => 'Dreamcast',
            'url' => 'dreamcast',
        ]);
        DB::table('systems')->insert([
            'name' => 'Playstation 2',
            'url' => 'ps2',
        ]);
        DB::table('systems')->insert([
            'name' => 'Game Cube',
            'url' => 'gamecube',
        ]);
        DB::table('systems')->insert([
            'name' => 'Xbox (original)',
            'url' => 'xbox',
        ]);
        DB::table('systems')->insert([
            'name' => 'Sega Saturn',
            'url' => 'saturn',
        ]);
        DB::table('systems')->insert([
            'name' => 'Playstation 1',
            'url' => 'ps1',
        ]);
    }
}
