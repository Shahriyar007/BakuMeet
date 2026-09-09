<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Wi-Fi', 'emoji' => '📶'],
            ['name' => 'Laptop Dostu', 'emoji' => '💻'],
            ['name' => 'Açık Hava', 'emoji' => '🌳'],
            ['name' => 'Canlı Müzik', 'emoji' => '🎵'],
            ['name' => 'Geç Saate Kadar Açık', 'emoji' => '🌙'],
            ['name' => 'Evcil Hayvan Dostu', 'emoji' => '🐾'],
            ['name' => 'Aile Dostu', 'emoji' => '👨‍👩‍👧'],
            ['name' => 'Sessiz', 'emoji' => '🤫'],
            ['name' => 'Ders Çalışmaya Uygun', 'emoji' => '📚'],
        ];

       if (Tag::count() > 0) {
            return;
        }
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
