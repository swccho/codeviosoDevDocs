<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds composite index (status, published_at) for faster public listing.
     */
    public function up(): void
    {
        Schema::table('docs', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docs', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });
    }
};
