<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'name' => 'Myth Made Hakkında',
            'content' => 'Hakkımızda yazısı burada',
            'text_1' => 'ÜCRETSIZ KARGO',
            'text_1_icon' => 'icon-truck',
            'text_1_content' => 'Satın aldığınız ürün ücretsiz olarak üç gün içinde kargolanır',
            'text_2' => 'GERİ İADE',
            'text_2_icon' => 'icon-refresh2',
            'text_2_content' => '30 gün içerisinde geri iade sağlanır',
            'text_3' => '7/24 DESTEK',
            'text_3_icon' => 'icon-help',
            'text_3_content' => '7 gün 24 saat bize ulaşabilirsiniz',
        ]);
    }
}
