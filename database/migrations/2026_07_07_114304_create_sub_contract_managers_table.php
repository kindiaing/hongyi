<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_contract_managers', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->foreignId('sub_contract_id')->constrained('sub_contracts')->cascadeOnDelete()->comment('关联分包合同ID');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('关联项目经理用户ID');
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->unique(['sub_contract_id', 'user_id'], 'scm_unique')->comment('同一项目经理同一合同唯一');
            $table->index('sub_contract_id')->comment('分包合同索引');
            $table->index('user_id')->comment('用户索引');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_contract_managers');
    }
};
