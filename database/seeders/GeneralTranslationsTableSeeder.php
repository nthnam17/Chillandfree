<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GeneralTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_translations')->insert([
            'general_id' => 1,
            'name' => 'Vnext Global Update',
            'address' => '2 update',
            'title' => 'Update Có thể Edit -update Cắt giảm chi phí sản xuất mà không ảnh hưởng đến chất lượng',
            'content' => 'Update Co thể Edit-VNEXT HOLDINGS đảm nhận nhiều hoạt động phát triển hệ thống trên cơ sở hợp đồng. Chúng tôi cung cấp các dịch vụ đáp ứng nhu cầu của khách hàng với các công nghệ hàng đầu tại Việt Nam',
            'meta_title' => 'VNEXT GLOBAL',
            'meta_description' => 'VNEXT GLOBAL',
            'meta_keyword' => 'VNEXT GLOBAL',
            'locale' => 'vi',
        ]);
        DB::table('general_translations')->insert([
            'general_id' => 1,
            'name' => 'Vnext Global Update',
            'address' => '2 update',
            'title' => 'Update Có thể Edit -update Cắt giảm chi phí sản xuất mà không ảnh hưởng đến chất lượng',
            'content' => 'Update Co thể Edit-VNEXT HOLDINGS đảm nhận nhiều hoạt động phát triển hệ thống trên cơ sở hợp đồng. Chúng tôi cung cấp các dịch vụ đáp ứng nhu cầu của khách hàng với các công nghệ hàng đầu tại Việt Nam',
            'meta_title' => 'VNEXT GLOBAL',
            'meta_description' => 'VNEXT GLOBAL',
            'meta_keyword' => 'VNEXT GLOBAL',
            'locale' => 'en',
        ]);
    }
}
