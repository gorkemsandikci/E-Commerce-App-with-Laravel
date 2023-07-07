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
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Erkek Kazak',
            'content' => 'Erkek Kazaklar',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $erkek->id,
            'status' => '1'
        ]);


        Category::create([
            'name' => 'Erkek Pantolon',
            'content' => 'Erkek Pantolonlar',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $erkek->id,
            'status' => '1'
        ]);


        $kadin = Category::create([
            'name' => 'Kadın',
            'content' => 'Kadın Giyim',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Kadın Çanta',
            'content' => 'Kadın Çantalar',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $kadin->id,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Kadın Pantolon',
            'content' => 'Kadın Pantolonlar',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $kadin->id,
            'status' => '1'
        ]);

        $cocuk = Category::create([
            'name' => 'Çocuk',
            'content' => 'Çocuk Giyim',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Çocuk Pantolon',
            'content' => 'Çocuk Pantolonlar',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $cocuk->id,
            'status' => '1'
        ]);

        Category::create([
            'name' => 'Çocuk Oyuncak',
            'content' => 'Çocuk Oyuncaklar',
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $cocuk->id,
            'status' => '1'
        ]);
    }
}
