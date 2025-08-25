<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessRightsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('access_rights')->delete();

        DB::table('access_rights')->insert([
            [
                'id' => '469e2e8f-b392-4241-9d8b-fdf9c64279ff',
                'admin_id' => 'bd3c5570-59c2-423e-b6f7-1702c31258e1',
                'links' => 1,
                'visitors' => 1,
                'settings' => 1,
                'admin_staff' => 1,
                'created_at' => '2023-01-06 19:18:47',
                'updated_at' => '2023-01-06 19:18:47',
            ],
            [
                'id' => '4740deca-e5ab-42af-8112-48a004096174',
                'admin_id' => 'ceee3c6d-8f57-414e-a287-c652eb5d4bbc',
                'links' => 1,
                'visitors' => 1,
                'settings' => 1,
                'admin_staff' => 1,
                'created_at' => '2024-01-17 14:36:50',
                'updated_at' => '2024-01-18 10:34:15',
            ]
        ]);
    }
}
