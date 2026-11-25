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
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();

            // Content
            $table->string('name')->index();
            $table->string('slug'); // Unique index for fast SEO lookups
            $table->text('description');

            // Relationships
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            // Constraints
            $table->unique(['product_id', 'language_id']); // One translation per language
            $table->unique(['language_id', 'slug']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
