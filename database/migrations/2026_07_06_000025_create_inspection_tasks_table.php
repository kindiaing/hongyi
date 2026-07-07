<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_no', 100)->unique();
            $table->foreignId('plan_id')->nullable()->constrained('inspection_plans')->nullOnDelete();
            $table->foreignId('template_id')->constrained('inspection_templates')->cascadeOnDelete();
            $table->string('task_name');
            $table->string('task_type', 50)->comment('巡检/回访');
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('target_type', 50);
            $table->unsignedBigInteger('target_id');
            $table->foreignId('assignee_id')->constrained('personnel')->cascadeOnDelete();
            $table->date('planned_date');
            $table->time('planned_time')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->decimal('sign_in_lat', 10, 7)->nullable();
            $table->decimal('sign_in_lng', 10, 7)->nullable();
            $table->string('sign_in_address', 255)->nullable();
            $table->tinyInteger('overall_result')->nullable()->comment('0异常,1正常');
            $table->text('exception_desc')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0待执行,1执行中,2待审核,3已完成,4已逾期');
            $table->foreignId('auditor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('audit_time')->nullable();
            $table->tinyInteger('audit_result')->nullable()->comment('0不通过,1通过');
            $table->text('audit_comment')->nullable();
            $table->tinyInteger('rectification_required')->default(0);
            $table->date('rectification_deadline')->nullable();
            $table->timestamps();
            $table->index('plan_id');
            $table->index('vendor_id');
            $table->index('assignee_id');
            $table->index('status');
            $table->index('planned_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_tasks');
    }
};
