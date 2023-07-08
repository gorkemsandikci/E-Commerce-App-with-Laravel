<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Urun 1',
            'image' => 'images/shoe_1.jpg',
            'category_id' => 1,
            'content' => '<p>Ürün açıklaması</p>',
            'short_text' => 'Kısabilgi',
            'price' => 250,
            'status' => '1',
            'size' => 'Small',
            'color' => 'Siyah',
            'qty' => 10,
        ]);

        Product::create([
            'name' => 'Urun 2',
            'image' => 'images/cloth_2.jpg',
            'category_id' => 2,
            'content' => '<p>Ürün 2 açıklaması</p>',
            'short_text' => 'Kısabilgi 2',
            'price' => 254,
            'status' => '1',
            'size' => 'Large',
            'color' => 'Beyaz',
            'qty' => 16,
        ]);
    }
}
