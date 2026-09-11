<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_accounts', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });

        Schema::table('business_accounts', function (Blueprint $table) {
            $table->foreignId('establishment_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('business_accounts', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });

        Schema::table('business_accounts', function (Blueprint $table) {
            $table->foreignId('establishment_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }
};
