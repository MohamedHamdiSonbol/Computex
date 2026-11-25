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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            // Timing
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            // Advanced Targeting
            $table->nullableMorphs('campaignable'); //campaignable_type(all - category - product- brand) -- campaignable_id

            // Business Logic
            $table->integer('priority')->default(1); // Higher number = wins if campaigns overlap
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_stackable')->default(false); // Can be used with coupons?

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
