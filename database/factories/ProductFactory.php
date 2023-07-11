<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        $category_id = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $size_list = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $color_list = ['Beyaz', 'Siyah', 'Mavi', 'Kırmızı', 'Yeşil', 'Pembe'];

        $color_text = $color_list[random_int(0, 5)];
        $size_text = $size_list[random_int(0, 5)];
        return [
            'name' => $color_text. ' ' .$size_text. ' Urun',
            'category_id' => $category_id[random_int(0, 8)],
            'content' => fake()->name(). 'İçerik yazısı güncellenecek',
            'short_text' => $category_id[random_int(0, 8)] . ' idli ürün.',
            'size' => $size_text,
            'image' => 'images/cloth_2.jpg',
            'color' => $color_list[random_int(0, 5)],
            'qty' => random_int(1, 50),
            'status' => '1',
            'price' => random_int(10, 700),
        ];
    }
}
