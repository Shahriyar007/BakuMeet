<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Establishment;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        // Koleksiyon 1: Eski Şehir'de Kahve Molası
        $collection1 = Collection::create([
            'title' => "Eski Şehir'de Kahve Molası",
            'description' => 'İçərişəhər\'in tarihi sokaklarında keyifli bir mola.',
            'emoji' => '☕',
        ]);
        $collection1->establishments()->attach(
            Establishment::where('location', 'İçərişəhər')->pluck('id')
        );

        // Koleksiyon 2: Sabail'de Romantik Akşam
        $collection2 = Collection::create([
            'title' => "Sabail'de Romantik Akşam",
            'description' => 'Özel bir akşam için Sabail\'in en şık mekanları.',
            'emoji' => '💕',
        ]);
        $collection2->establishments()->attach(
            Establishment::where('location', 'Sabail')->pluck('id')
        );

        // Koleksiyon 3: Bütçe Dostu Seçenekler
        $collection3 = Collection::create([
            'title' => 'Bütçe Dostu Seçenekler',
            'description' => 'Cebini yormadan doyacağın ve keyif alacağın yerler.',
            'emoji' => '💰',
        ]);
        $collection3->establishments()->attach(
            Establishment::where('mood', 'bütçedostu')->pluck('id')
        );
    }
}
