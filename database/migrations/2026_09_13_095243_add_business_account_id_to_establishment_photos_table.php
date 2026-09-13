<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('establishment_photos_new', function ($table) {
            $table->id();
            $table->unsignedBigInteger('establishment_id')->nullable();
            $table->unsignedBigInteger('business_account_id')->nullable();
            $table->string('path');
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('establishment_id')->references('id')->on('establishments')->cascadeOnDelete();
            $table->foreign('business_account_id')->references('id')->on('business_accounts')->cascadeOnDelete();
        });

        DB::statement('INSERT INTO establishment_photos_new (id, establishment_id, path, is_primary, sort_order, created_at, updated_at)
            SELECT id, establishment_id, path, is_primary, sort_order, created_at, updated_at FROM establishment_photos');

        Schema::drop('establishment_photos');
        Schema::rename('establishment_photos_new', 'establishment_photos');
    }

    public function down(): void
    {
        Schema::table('establishment_photos', function ($table) {
            $table->dropForeign(['business_account_id']);
            $table->dropColumn('business_account_id');
        });
    }
};
