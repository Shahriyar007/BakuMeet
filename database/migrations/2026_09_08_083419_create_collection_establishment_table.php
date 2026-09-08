<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_establishment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained()->onDelete('cascade');
            $table->foreignId('establishment_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['collection_id', 'establishment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_establishment');
    }
};
