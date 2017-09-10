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
            'id' => 4920,
            'name' => 'Xbox One',
            'url' => 'xbox-one',
        ]);
        DB::table('systems')->insert([
            'id' => 15,
            'name' => 'Xbox 360',
            'url' => 'xbox-360',
        ]);
        DB::table('systems')->insert([
            'id' => 4919,
            'name' => 'Playstation 4',
            'url' => 'ps4',
        ]);
        DB::table('systems')->insert([
            'id' => 12,
            'name' => 'Playstation 3',
            'url' => 'ps3',
        ]);
        DB::table('systems')->insert([
            'id' => 38,
            'name' => 'Wii U',
            'url' => 'wii-u',
        ]);
        DB::table('systems')->insert([
            'id' => 9,
            'name' => 'Wii',
            'url' => 'wii',
        ]);
        DB::table('systems')->insert([
            'id' => 8,
            'name' => 'DS',
            'url' => 'ds',
        ]);
        DB::table('systems')->insert([
            'id' => 4912,
            'name' => '3DS',
            'url' => '3ds',
        ]);
        DB::table('systems')->insert([
            'id' => 39,
            'name' => 'PS Vita',
            'url' => 'vita',
        ]);
        DB::table('systems')->insert([
            'id' => 13,
            'name' => 'PSP',
            'url' => 'psp',
        ]);
        DB::table('systems')->insert([
            'id' => 16,
            'name' => 'Dreamcast',
            'url' => 'dreamcast',
        ]);
        DB::table('systems')->insert([
            'id' => 11,
            'name' => 'Playstation 2',
            'url' => 'ps2',
        ]);
        DB::table('systems')->insert([
            'id' => 2,
            'name' => 'Game Cube',
            'url' => 'gamecube',
        ]);
        DB::table('systems')->insert([
            'id' => 14,
            'name' => 'Xbox (original)',
            'url' => 'xbox',
        ]);
        DB::table('systems')->insert([
            'id' => 17,
            'name' => 'Sega Saturn',
            'url' => 'saturn',
        ]);
        DB::table('systems')->insert([
            'id' => 10,
            'name' => 'Playstation 1',
            'url' => 'ps1',
        ]);
    }
}
