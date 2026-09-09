<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedTinyInteger('atmosphere_rating')->nullable()->after('rating');
            $table->unsignedTinyInteger('food_rating')->nullable()->after('atmosphere_rating');
            $table->unsignedTinyInteger('service_rating')->nullable()->after('food_rating');
            $table->unsignedTinyInteger('value_rating')->nullable()->after('service_rating');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['atmosphere_rating', 'food_rating', 'service_rating', 'value_rating']);
        });
    }
};
