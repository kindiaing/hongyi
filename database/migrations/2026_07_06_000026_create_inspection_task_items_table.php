<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_task_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('inspection_tasks')->cascadeOnDelete();
            $table->foreignId('template_item_id')->constrained('inspection_template_items')->cascadeOnDelete();
            $table->text('result_value')->nullable();
            $table->tinyInteger('is_normal')->nullable()->comment('0异常,1正常');
            $table->text('abnormal_desc')->nullable();
            $table->timestamps();
            $table->index('task_id');
            $table->index('template_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_task_items');
    }
};
