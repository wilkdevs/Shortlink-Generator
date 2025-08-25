<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            [
                'id' => 'e7246836-53b6-4c88-a3eb-72c1c8d79b05',
                'name' => 'Wilkdevs',
                'email' => 'wilkdevs@gmail.com',
                'password' => '$2y$10$/1MOFB6Rijjlci3ECGLR1OJRkdQxOMGgOpq3CvD5m8769BXcJXmsi',
                'created_at' => '2023-01-06 19:18:47',
                'updated_at' => '2023-01-06 19:18:47',
            ],
            [
                'id' => 'fa953acb-df5f-4f73-ada0-6b50a0efb553',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$B6zQmxYmvu9OmuTzRQtv8.qNoREjDSp6Ew8dWA4yWq7Xv6/bSq3gS',
                'created_at' => '2022-11-23 10:02:22',
                'updated_at' => '2024-02-04 04:04:50',
            ],
        ]);
    }
}
