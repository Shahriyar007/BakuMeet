<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('establishment_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained()->cascadeOnDelete();
            $table->string('visitor_id', 64);
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('viewed_at')->useCurrent();
        });

        Schema::table('establishment_views', function (Blueprint $table) {
            $table->index(['establishment_id', 'viewed_at']);
            $table->index(['establishment_id', 'visitor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('establishment_views');
    }
};
