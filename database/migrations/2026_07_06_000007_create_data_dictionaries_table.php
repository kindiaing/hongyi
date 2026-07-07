<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('category', 100);
            $table->string('code', 100);
            $table->string('name');
            $table->string('value')->nullable();
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('is_enabled')->default(1);
            $table->string('description', 500)->nullable();
            $table->timestamps();
            $table->unique(['category', 'code']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_dictionaries');
    }
};
