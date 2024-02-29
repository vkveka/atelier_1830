<?php

namespace Database\Seeders;

use App\Models\Satisfaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AskingSeeder::class,
            GammeSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            CommentSeeder::class,
            SatisfactionSeeder::class,
            CommandeSeeder::class,
            CommandeArticleSeeder::class,
            CatalogueSeeder::class,
        ]);
    }
}
