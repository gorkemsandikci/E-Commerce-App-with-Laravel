<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $erkek = Category::create([
            'name' => 'Erkek',
            'content' => 'Erkek Giyim',
            'image' => '/img/men.jpg',
            'thumbnail' => null,
            'cat_ust' => null,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Erkek Kazak',
            'content' => 'Erkek Kazaklar',
            'image' => '/img/men.jpg',
            'thumbnail' => null,
            'cat_ust' => $erkek->id,
            'status' => '1'
        ]);


        Category::create([
            'name' => 'Erkek Pantolon',
            'content' => 'Erkek Pantolonlar',
            'image' => '/img/men.jpg',
            'thumbnail' => null,
            'cat_ust' => $erkek->id,
            'status' => '1'
        ]);


        $kadin = Category::create([
            'name' => 'Kadın',
            'content' => 'Kadın Giyim',
            'image' => '/img/women.jpg',
            'thumbnail' => null,
            'cat_ust' => null,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Kadın Çanta',
            'content' => 'Kadın Çantalar',
            'image' => '/img/women.jpg',
            'thumbnail' => null,
            'cat_ust' => $kadin->id,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Kadın Pantolon',
            'content' => 'Kadın Pantolonlar',
            'image' => '/img/women.jpg',
            'thumbnail' => null,
            'cat_ust' => $kadin->id,
            'status' => '1'
        ]);

        $cocuk = Category::create([
            'name' => 'Çocuk',
            'content' => 'Çocuk Giyim',
            'image' => '/img/children.jpg',
            'thumbnail' => null,
            'cat_ust' => null,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Çocuk Pantolon',
            'content' => 'Çocuk Pantolonlar',
            'image' => '/img/children.jpg',
            'thumbnail' => null,
            'cat_ust' => $cocuk->id,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Çocuk Oyuncak',
            'content' => 'Çocuk Oyuncaklar',
            'image' => '/img/children.jpg',
            'thumbnail' => null,
            'cat_ust' => $cocuk->id,
            'status' => '1'
        ]);
    }
}
