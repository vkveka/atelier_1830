<?php

namespace Database\Seeders;

use App\Models\Catalogue;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Catalogue::create([
            'title' => 'Photo du catalogue',
            'image' => '_DSC0019-2.jpg',
        ]);
        Catalogue::create([
            'title' => 'Photo du catalogue',
            'image' => '_DSC0023-2.jpg',
        ]);
        Catalogue::create([
            'title' => 'Photo du catalogue',
            'image' => 'coussin_canapé.jpeg',
        ]);
    }
}
