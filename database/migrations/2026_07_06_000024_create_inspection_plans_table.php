<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->foreignId('template_id')->constrained('inspection_templates')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('target_type', 50)->comment('software/hardware');
            $table->unsignedBigInteger('target_id');
            $table->string('cycle_type', 50)->comment('日/周/双周/月/季度/自定义');
            $table->integer('cycle_days')->nullable()->comment('自定义周期天数');
            $table->time('execute_time');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->foreignId('assignee_id')->nullable()->constrained('personnel')->nullOnDelete();
            $table->tinyInteger('is_enabled')->default(1);
            $table->timestamp('last_generated_at')->nullable();
            $table->timestamp('next_generate_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('template_id');
            $table->index('vendor_id');
            $table->index(['target_type', 'target_id']);
            $table->index('is_enabled');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_plans');
    }
};
