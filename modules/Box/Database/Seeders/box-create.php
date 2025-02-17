<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Helpers\SeederHelper;

return new class extends Seeder
{
    public function run()
    {
        DB::table('box')->insert([
            [
                'brand_id' => 1,
                'name' => SeederHelper::localized('Box 1'),
                'slug' => 'box-1',
                'description' => '[]',
                'price' => 2000,
                'date' => date('Y-m-d'),
                'datetime' => date('Y-m-d H:i:00'),
                'image' => '/test_data/images/2.png',
                'images_list' => json_encode([
                    '/test_data/images/1.png',
                    '/test_data/images/2.png',
                    '/test_data/images/3.png',
                ]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'brand_id' => 1,
                'name' => SeederHelper::localized('Box 2'),
                'slug' => 'box-2',
                'description' => '[]',
                'price' => 5500,
                'date' => date('Y-m-d'),
                'datetime' => date('Y-m-d H:i:00'),
                'image' => '/test_data/images/3.png',
                'images_list' => json_encode([
                    '/test_data/images/1.png',
                ]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
};
