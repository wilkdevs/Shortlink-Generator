<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetatagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metatag')->delete();

        DB::table('metatag')->insert([
            'id' => '1',
            'title' => 'Shortlink Generator - BRAND123',
            'desc' => 'Rayakan kemerdekaan indonesia dengan Shortlink Generator',
            'keyword' => 'Shortlink Generator, BRAND123',
            'created_at' => '2022-04-06 03:56:51',
            'updated_at' => '2025-07-21 13:42:50',
        ]);
    }
}
