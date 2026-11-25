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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->morphs('discountable');
            // Calculation
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 10, 2);

            // Real-life Conditions
            $table->integer('min_quantity')->default(1); // e.g., "Buy 2 to get the discount"
            $table->decimal('min_order_value', 10, 2)->nullable();
            $table->integer('usage_limit_per_user')->nullable(); // Prevents resellers from clearing stock

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
