<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'name' => 'address',
            'data' => 'İstanbul adres bilgilerim'
        ]);

        SiteSetting::create([
            'name' => 'phone',
            'data' => '545 891 89 05'
        ]);

        SiteSetting::create([
            'name' => 'email',
            'data' => 'gorkem@gorkemnet.com'
        ]);

        SiteSetting::create([
            'name' => 'map',
            'data' => ''
        ]);
    }
}
