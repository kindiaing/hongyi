<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_task_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('inspection_tasks')->cascadeOnDelete();
            $table->foreignId('task_item_id')->nullable()->constrained('inspection_task_items')->nullOnDelete();
            $table->string('photo_url', 500);
            $table->string('photo_desc', 255)->nullable();
            $table->timestamp('taken_at')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();
            $table->index('task_id');
            $table->index('task_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_task_photos');
    }
};
