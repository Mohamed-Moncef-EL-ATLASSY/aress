<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('company_source_id')
                ->nullable()
                ->constrained('company_sources')
                ->nullOnDelete()
                ->after('company_source');
            $table->json('events')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['company_source_id']);
            $table->dropColumn('company_source_id');
            $table->dropColumn('events');
        });
    }
};
