<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('setting')->delete();

        DB::table('setting')->insert([
            [
                'id' => '0',
                'key' => 'websiteName',
                'title' => 'Website Name',
                'value' => 'Shortlink Generator - Brand123',
                'default_value' => null,
                'type' => 'text',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-21 05:57:54',
            ],
            [
                'id' => '31',
                'key' => 'logoImage',
                'title' => 'Logo Brand',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-21 08:41:54',
            ],
            [
                'id' => '32',
                'key' => 'faviconImage',
                'title' => 'Favicon Image ',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-21 08:42:02',
            ],
            [
                'id' => '41',
                'key' => 'backgroundImage',
                'title' => 'Gambar Latar Utama',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:34:39',
            ],
            [
                'id' => '51',
                'key' => 'adminLink',
                'title' => 'Link Admin',
                'value' => null,
                'default_value' => "https://wa.me/6287790900101",
                'type' => 'text',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:54:11',
            ],
        ]);
    }
}
