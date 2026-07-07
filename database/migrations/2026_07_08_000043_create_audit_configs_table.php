<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_configs', function (Blueprint $table) {
            $table->id();
            $table->string('audit_type', 50)->unique()->comment('审计类型标识');
            $table->string('audit_name', 100)->comment('审计类型名称');
            $table->string('audit_module', 50)->comment('所属模块');
            $table->boolean('is_enabled')->default(true)->comment('是否启用审计');
            $table->boolean('record_create')->default(true)->comment('是否记录创建操作');
            $table->boolean('record_update')->default(true)->comment('是否记录编辑操作');
            $table->boolean('record_delete')->default(true)->comment('是否记录删除操作');
            $table->boolean('record_view')->default(false)->comment('是否记录查看操作');
            $table->boolean('record_old_data')->default(true)->comment('是否记录变更前数据');
            $table->boolean('record_new_data')->default(true)->comment('是否记录变更后数据');
            $table->text('description')->nullable()->comment('说明');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_configs');
    }
};
