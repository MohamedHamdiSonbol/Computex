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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('abbr', 10)->unique();
            $table->string('local', 20)->unique()->nullable();
            $table->string('name', 50)->unique();
            $table->enum('direction', ['ltr', 'rtl'])->default('rtl');
            $table->tinyInteger('active')->default(0)->comment('0 => inactive , 1 => active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
