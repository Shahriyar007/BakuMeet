<?php

namespace Database\Seeders;

use App\Models\Establishment;
use Illuminate\Database\Seeder;

class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // RESTORANLAR
            [
                'name' => 'Qafqaz Palace Restaurant',
                'type' => 'restaurant',
                'description' => 'Bakü\'nün en ünlü Azerbaycan mutfağı restoranı. Geleneksel lezzetler ve modern sunuş.',
                'location' => 'Sabail',
                'mood' => 'lüks',
                'image' => null,
                'latitude' => 40.3697,
                'longitude' => 49.8671,
                'rating' => 4.8,
            ],
            [
                'name' => 'Shirvanshah',
                'type' => 'restaurant',
                'description' => 'Geleneksel Azerbaycan kebabları ve pilav. Aile ortamında doyurucu yemekler.',
                'location' => 'Nizami',
                'mood' => 'sakin',
                'image' => null,
                'latitude' => 40.3764,
                'longitude' => 49.8314,
                'rating' => 4.5,
            ],
            [
                'name' => 'Fiesta Restaurant',
                'type' => 'restaurant',
                'description' => 'Uluslararası ve Azerbaycan mutfağı. Romantik balkonlu manzara.',
                'location' => 'Bayıl',
                'mood' => 'romantik',
                'image' => null,
                'latitude' => 40.3689,
                'longitude' => 49.8830,
                'rating' => 4.6,
            ],
            [
                'name' => 'Nargiz Restaurant',
                'type' => 'restaurant',
                'description' => 'Canlı atmosfer, dansçılar ve canlı müzik. Eğlenceli gece yemeği.',
                'location' => 'Yasamal',
                'mood' => 'canlı',
                'image' => null,
                'latitude' => 40.3900,
                'longitude' => 49.8450,
                'rating' => 4.3,
            ],
            [
                'name' => 'Old Town Kebab House',
                'type' => 'restaurant',
                'description' => 'Eski Şehir\'de geleneksel kebap. Uygun fiyatlı, doyurucu yemekler.',
                'location' => 'İçərişəhər',
                'mood' => 'bütçedostu',
                'image' => null,
                'latitude' => 40.3651,
                'longitude' => 49.8353,
                'rating' => 4.2,
            ],

            // KAFELER
            [
                'name' => 'Coffee House Baku',
                'type' => 'cafe',
                'description' => 'Artisan kahveler ve tatlılar. Çalışmak veya dinlenmek için ideal.',
                'location' => 'Nizami',
                'mood' => 'sakin',
                'image' => null,
                'latitude' => 40.3760,
                'longitude' => 49.8320,
                'rating' => 4.7,
            ],
            [
                'name' => 'Espresso Bar',
                'type' => 'cafe',
                'description' => 'Modern espresso bar. Hızlı servis, kaliteli kahve.',
                'location' => 'Sabail',
                'mood' => 'sakin',
                'image' => null,
                'latitude' => 40.3695,
                'longitude' => 49.8675,
                'rating' => 4.4,
            ],
            [
                'name' => 'Azeri Tea House',
                'type' => 'cafe',
                'description' => 'Geleneksel çay evi. Eski Şehir\'in merkezinde.',
                'location' => 'İçərişəhər',
                'mood' => 'sakin',
                'image' => null,
                'latitude' => 40.3655,
                'longitude' => 49.8355,
                'rating' => 4.6,
            ],
            [
                'name' => 'The Social Cafe',
                'type' => 'cafe',
                'description' => 'Gençlerin buluştuğu yerler. DJ müzik, sosyal ortam.',
                'location' => 'Yasamal',
                'mood' => 'canlı',
                'image' => null,
                'latitude' => 40.3905,
                'longitude' => 49.8455,
                'rating' => 4.3,
            ],
            [
                'name' => 'Budget Cafe',
                'type' => 'cafe',
                'description' => 'Ucuz kahve ve çay. Öğrenciler için ideal.',
                'location' => 'Nərimanov',
                'mood' => 'bütçedostu',
                'image' => null,
                'latitude' => 40.4000,
                'longitude' => 49.8500,
                'rating' => 3.9,
            ],
        ];

        foreach ($data as $item) {
            Establishment::create($item);
        }
    }
}
