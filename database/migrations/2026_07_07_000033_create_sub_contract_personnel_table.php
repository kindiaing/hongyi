<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_contract_personnel', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->foreignId('sub_contract_id')->constrained('sub_contracts')->cascadeOnDelete()->comment('关联分包合同ID');
            $table->foreignId('personnel_id')->constrained('personnel')->cascadeOnDelete()->comment('关联运维人员ID');
            $table->date('assigned_at')->nullable()->comment('人员分配日期');
            $table->date('ended_at')->nullable()->comment('人员结束日期');
            $table->tinyInteger('status')->default(1)->comment('状态: 0已移除,1在职');
            $table->text('remark')->nullable()->comment('备注');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('创建人');
            $table->timestamps();
            $table->index('sub_contract_id')->comment('分包合同索引');
            $table->index('personnel_id')->comment('人员索引');
            $table->unique(['sub_contract_id', 'personnel_id', 'status'], 'scp_unique_active')->comment('同一人员同一合同只能有一条在职记录');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_contract_personnel');
    }
};
