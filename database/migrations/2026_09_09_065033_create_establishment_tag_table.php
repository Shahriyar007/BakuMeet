<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('establishment_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['establishment_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('establishment_tag');
    }
};
