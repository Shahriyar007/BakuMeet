<?php

namespace Database\Seeders;

use App\Models\Establishment;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $e = Establishment::find(1);

        if (!$e || $e->opening_hours) {
            return;
        }

        $e->opening_hours = [
            'monday' => ['open' => '09:00', 'close' => '23:00'],
            'tuesday' => ['open' => '09:00', 'close' => '23:00'],
            'wednesday' => ['open' => '09:00', 'close' => '23:00'],
            'thursday' => ['open' => '09:00', 'close' => '23:00'],
            'friday' => ['open' => '09:00', 'close' => '23:00'],
            'saturday' => ['open' => '10:00', 'close' => '23:59'],
            'sunday' => ['closed' => true],
        ];
        $e->save();

        $e->tags()->syncWithoutDetaching([1, 2, 5]);
    }
}
