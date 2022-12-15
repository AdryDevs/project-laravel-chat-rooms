<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'name' => 'General',
            'description' => 'room for everyone',
        ]);
        DB::table('rooms')->insert([
            'name' => 'World of Warcraft',
            'description' => 'all about WoW',
        ]);
        DB::table('rooms')->insert([
            'name' => 'League of Legends',
            'description' => 'all about LoL',
        ]);
    }
}
