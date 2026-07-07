<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main_contract_managers', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->foreignId('main_contract_id')->constrained('main_contracts')->cascadeOnDelete()->comment('关联主合同ID');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('关联项目经理用户ID');
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->unique(['main_contract_id', 'user_id'], 'mcm_unique')->comment('同一项目经理同一合同唯一');
            $table->index('main_contract_id')->comment('主合同索引');
            $table->index('user_id')->comment('用户索引');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main_contract_managers');
    }
};
