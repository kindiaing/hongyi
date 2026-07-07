<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('inspection_templates')->cascadeOnDelete();
            $table->string('item_name');
            $table->string('item_type', 50)->comment('文本/单选/多选/数值/拍照');
            $table->json('options')->nullable();
            $table->text('standard')->nullable();
            $table->tinyInteger('is_required')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('template_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_template_items');
    }
};
