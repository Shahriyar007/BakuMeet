<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('establishment_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'establishment_id']); // aynı işletmeyi 2 kez favoriye ekleyemesin
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
