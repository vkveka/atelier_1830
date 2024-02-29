<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SatisfactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 2; $i++) {
            DB::table('satisfactions')->insert([
                'user_id' => rand(1, User::count()),
                'product_id' => rand(1, Product::count()),
                'note' => Arr::random(['bad', 'good', 'verygood']),
            ]);
        }
    }
}
