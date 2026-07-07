<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satisfaction_survey_plans', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->string('plan_name')->comment('计划名称');
            $table->foreignId('service_unit_id')->constrained('service_units')->cascadeOnDelete()->comment('关联服务单位ID');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete()->comment('关联运维单位ID');
            $table->string('cycle_type', 50)->comment('周期类型: monthly月度/quarterly季度/annually年度/custom自定义');
            $table->integer('cycle_month')->nullable()->comment('执行月份(1-12)，年度/季度计划用');
            $table->integer('cycle_day')->nullable()->comment('执行日期(1-31)');
            $table->date('start_date')->comment('计划开始日期');
            $table->date('end_date')->nullable()->comment('计划结束日期');
            $table->tinyInteger('remind_days')->default(3)->comment('提前提醒天数');
            $table->tinyInteger('is_enabled')->default(1)->comment('是否启用: 0停用,1启用');
            $table->timestamp('next_execute_at')->nullable()->comment('下次执行时间');
            $table->timestamp('last_executed_at')->nullable()->comment('上次执行时间');
            $table->text('remark')->nullable()->comment('备注');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('创建人');
            $table->timestamps();
            $table->softDeletes();
            $table->index('service_unit_id')->comment('服务单位索引');
            $table->index('vendor_id')->comment('运维单位索引');
            $table->index('cycle_type')->comment('周期类型索引');
            $table->index('is_enabled')->comment('启用状态索引');
            $table->index('next_execute_at')->comment('下次执行时间索引');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satisfaction_survey_plans');
    }
};
