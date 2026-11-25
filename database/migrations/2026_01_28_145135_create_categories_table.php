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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
//            $table->string('translation_lang', 10);
//            $table->integer('translation_of')->unsigned();
//            $table->string('name', 150);
//            $table->string('slug', 150);
            $table->string('photo', 150)->nullable();
            $table->tinyInteger('active')->default(0)->comment('0 => inactive , 1 => active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
