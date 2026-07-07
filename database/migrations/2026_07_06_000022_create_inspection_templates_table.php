<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_name');
            $table->string('template_type', 50)->comment('巡检/回访');
            $table->string('category', 50)->comment('软件/硬件/机房/综合');
            $table->text('description')->nullable();
            $table->tinyInteger('is_enabled')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('template_type');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_templates');
    }
};
