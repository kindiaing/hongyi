<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satisfaction_surveys', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->foreignId('plan_id')->nullable()->constrained('satisfaction_survey_plans')->nullOnDelete()->comment('关联回访计划ID(人工创建可为空)');
            $table->foreignId('service_unit_id')->constrained('service_units')->cascadeOnDelete()->comment('关联服务单位ID');
            $table->foreignId('personnel_id')->nullable()->constrained('personnel')->nullOnDelete()->comment('关联被评价运维人员ID');
            $table->date('survey_date')->comment('回访日期');
            $table->string('satisfaction_level', 50)->comment('满意度: very_satisfied非常满意/satisfied满意/general一般/dissatisfied不满意');
            $table->tinyInteger('service_attitude_score')->nullable()->comment('服务态度评分(1-5)');
            $table->tinyInteger('response_speed_score')->nullable()->comment('响应速度评分(1-5)');
            $table->tinyInteger('technical_level_score')->nullable()->comment('技术水平评分(1-5)');
            $table->text('overall_evaluation')->nullable()->comment('总体评价');
            $table->text('improvement_suggestions')->nullable()->comment('改进建议');
            $table->foreignId('surveyor_id')->nullable()->constrained('users')->nullOnDelete()->comment('调查人(项目经理)ID');
            $table->tinyInteger('status')->default(0)->comment('状态: 0待回访,1已完成');
            $table->text('remark')->nullable()->comment('备注');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('创建人');
            $table->timestamps();
            $table->softDeletes();
            $table->index('plan_id')->comment('回访计划索引');
            $table->index('service_unit_id')->comment('服务单位索引');
            $table->index('personnel_id')->comment('运维人员索引');
            $table->index('survey_date')->comment('回访日期索引');
            $table->index('satisfaction_level')->comment('满意度索引');
            $table->index('status')->comment('状态索引');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satisfaction_surveys');
    }
};
