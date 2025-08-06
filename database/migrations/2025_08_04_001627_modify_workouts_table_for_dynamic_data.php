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
        Schema::table('workouts', function (Blueprint $table) {
             // Remove the old, rigid columns
            $table->dropColumn(['duration_minutes', 'distance_km', 'notes']);

            // Add a single, flexible JSON column to store all details
            $table->json('details')->nullable()->after('type');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            // This is the reverse operation for rollbacks
            $table->dropColumn('details');
            $table->integer('duration_minutes')->nullable();
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->text('notes')->nullable();
        });
    }
};
