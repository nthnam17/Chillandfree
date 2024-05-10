<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GeneralTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general')->insert([
            'email' => 'namnth@tektra.com.vn',
            'phone' => '09665471982',
            'logo' => '/uploads/images/logo.png',
            'favicon' => '/uploads/images/logo.png',
            'add_head' => '',
            'add_body' => '',
            'banner_home' => '/uploads/images/anh_1.jpg',
        ]);
    }
}
