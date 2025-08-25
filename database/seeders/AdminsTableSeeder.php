<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert([
            [
                'id' => 'bd3c5570-59c2-423e-b6f7-1702c31258e1',
                'user_id' => 'e7246836-53b6-4c88-a3eb-72c1c8d79b05',
                'created_at' => null,
                'updated_at' => '2023-01-11 15:05:54',
            ],
            [
                'id' => 'ceee3c6d-8f57-414e-a287-c652eb5d4bbc',
                'user_id' => 'fa953acb-df5f-4f73-ada0-6b50a0efb553',
                'created_at' => null,
                'updated_at' => '2022-10-26 11:33:03',
            ],
        ]);
    }
}
