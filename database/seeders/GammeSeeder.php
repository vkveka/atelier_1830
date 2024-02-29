<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gamme;

class GammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gamme::create([
            'name' => 'rideau',
            'image' => '_DSC0019-2.jpg',
        ]);

        Gamme::create([
            'name' => 'coussin',
            'image' => 'coussin_couture_dessus.jpeg',
        ]);

        Gamme::create([
            'name' => 'autre',
            'image' => 'IMG_20221108_212626.jpg',
        ]);
    }
}
