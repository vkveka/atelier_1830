<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Product::factory(20)->create();

        Product::create([
            'name' => 'Coussin Soyeux',
            'desc' => 'Luxueux coussin en soie.',
            'full_desc' => 'Ce coussin en soie pure ajoute une touche d\'élégance à votre espace, avec sa texture douce et son design raffiné.',
            'image' => 'coussin_couture_dessus.jpeg',
            'price' => '32.00',
            'dispo' => '1',
            'gamme_id' => '2',
        ]);
        Product::create([
            'name' => 'Coussin Bohème',
            'desc' => 'Coussin bohème chic.',
            'full_desc' => 'Ce coussin bohème aux motifs vibrants apporte une atmosphère décontractée et artistique à votre intérieur.',
            'image' => 'couture_coussin_cuir.jpeg',
            'price' => '45.99',
            'dispo' => '1',
            'gamme_id' => '2',
        ]);
        Product::create([
            'name' => 'Coussin Velours',
            'desc' => 'Coussin en velours doux.',
            'full_desc' => 'Le velours somptueux de ce coussin vous invite à la détente, ajoutant une touche d\'opulence à votre espace.',
            'image' => 'coussin_bnw.jpeg',
            'price' => '50.99',
            'dispo' => '1',
            'gamme_id' => '2',
        ]);
        Product::create([
            'name' => 'Rideau Élégant',
            'desc' => 'Rideau élégant sur mesure.',
            'full_desc' => 'Nos rideaux sur mesure transforment votre fenêtre en un élément de design sophistiqué, alliant fonctionnalité et style.',
            'image' => '_DSC0019-2.jpg',
            'price' => '37.50',
            'dispo' => '1',
            'gamme_id' => '1',
        ]);
        Product::create([
            'name' => 'Rideau Floral',
            'desc' => 'Rideau floral frais.',
            'full_desc' => 'Créez une ambiance florale avec ce rideau raffiné, qui apporte la nature à l\'intérieur de votre maison.',
            'image' => 'IMG20230606112058.jpg',
            'price' => '28.90',
            'dispo' => '1',
            'gamme_id' => '1',
        ]);
        Product::create([
            'name' => 'Rideau Bohème',
            'desc' => 'Rideau bohème artistique.',
            'full_desc' => 'Donnez à votre espace une touche artistique et décontractée avec ce rideau bohème aux motifs uniques.',
            'image' => 'IMG20230606112049_2.jpg',
            'price' => '55.00',
            'dispo' => '1',
            'gamme_id' => '1',
        ]);
        Product::create([
            'name' => 'Housse Canapé',
            'desc' => 'Housse de canapé personnalisée.',
            'full_desc' => 'Offrez une seconde vie à votre canapé avec notre housse sur mesure, alliant praticité et esthétique.',
            'image' => 'default_picture8.jpg',
            'price' => '60.99',
            'dispo' => '1',
            'gamme_id' => '3',
        ]);
        Product::create([
            'name' => 'Coussin Patchwork',
            'desc' => 'Coussin patchwork unique.',
            'full_desc' => 'Chaque coussin patchwork est une pièce unique, mélange de tissus colorés pour une déco originale.',
            'image' => 'gamme_coussin.jpg',
            'price' => '40.00',
            'dispo' => '1',
            'gamme_id' => '2',
        ]);
        Product::create([
            'name' => 'Housse Matelas',
            'desc' => 'Protection matelas.',
            'full_desc' => 'Gardez votre matelas propre et frais avec notre housse de matelas de qualité, offrant une protection optimale pour un sommeil paisible.',
            'image' => 'default_picture3.jpg',
            'price' => '39.99',
            'dispo' => '1',
            'gamme_id' => '3',
        ]);
        Product::create([
            'name' => 'Panier Tissé',
            'desc' => 'Panier tissé artisanal.',
            'full_desc' => 'Notre panier tissé à la main est à la fois fonctionnel et esthétique, parfait pour organiser et décorer votre espace.',
            'image' => 'IMG_20221108_212626.jpg',
            'price' => '19.90',
            'dispo' => '1',
            'gamme_id' => '3',
        ]);
    }
}
