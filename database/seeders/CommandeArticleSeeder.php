<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Commande;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommandeArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            DB::table('commande_articles')->insert([
                'commande_id' => rand(1, Commande::count()),
                'product_id' => rand(1, Product::count()),
                'quantity' => rand(1,5),
            ]);
        }
    }
}
