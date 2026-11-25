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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();

            $table->string('customer_name');
            $table->string('phone');
            $table->text('address');
            $table->enum('shipping', ['0', '50',])->default('50');
            $table->smallInteger('fees')->nullable()->default(0);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', [
                'pending',
                'shipped',
                'delivered',
                'rejected',
            ])->default('pending');
            $table->unique(['customer_id', 'coupon_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
