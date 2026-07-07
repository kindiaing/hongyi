<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software_faults', function (Blueprint $table) {
            $table->id();
            $table->foreignId('software_id')->constrained('software')->cascadeOnDelete();
            $table->string('fault_no', 100)->unique();
            $table->string('fault_level', 50)->comment('critical紧急/major重大/minor一般');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('reporter_name', 100);
            $table->string('reporter_phone', 20)->nullable();
            $table->timestamp('report_time')->useCurrent();
            $table->foreignId('handler_id')->nullable()->constrained('personnel')->nullOnDelete();
            $table->timestamp('handle_time')->nullable();
            $table->text('handle_result')->nullable();
            $table->timestamp('resolve_time')->nullable();
            $table->tinyInteger('is_sla_met')->nullable()->comment('是否满足SLA');
            $table->tinyInteger('status')->default(0)->comment('0待处理,1处理中,2已解决,3已关闭');
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->index('software_id');
            $table->index('fault_level');
            $table->index('status');
            $table->index('report_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software_faults');
    }
};
