<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slider::create([
            'image' => '/images/hero_1.jpg',
            'name' => 'Slider1',
            'content' => 'E-Ticaret Sitemize Hoşgeldiniz',
            'link' => 'urunler',
            'status' => '1'
        ]);
    }
}
