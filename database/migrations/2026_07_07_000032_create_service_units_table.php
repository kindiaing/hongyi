<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_units', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->string('name')->comment('服务单位名称');
            $table->string('short_name', 100)->nullable()->comment('简称');
            $table->string('address', 500)->nullable()->comment('单位地址');
            $table->string('contact_name', 100)->nullable()->comment('联系人姓名');
            $table->string('contact_phone', 20)->nullable()->comment('联系人电话');
            $table->string('contact_email', 255)->nullable()->comment('联系人邮箱');
            $table->tinyInteger('status')->default(1)->comment('状态: 0停用,1启用');
            $table->text('remark')->nullable()->comment('备注');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('创建人');
            $table->timestamps();
            $table->softDeletes();
            $table->index('name')->comment('服务单位名称索引');
            $table->index('status')->comment('状态索引');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_units');
    }
};
