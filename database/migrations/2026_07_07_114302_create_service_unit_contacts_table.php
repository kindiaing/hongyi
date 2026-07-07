<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_unit_contacts', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->foreignId('service_unit_id')->constrained('service_units')->cascadeOnDelete()->comment('关联服务单位ID');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->comment('关联系统用户ID（可登录时）');
            $table->string('name', 100)->comment('姓名');
            $table->string('phone', 20)->comment('手机号');
            $table->string('position', 100)->nullable()->comment('职务');
            $table->string('email', 255)->nullable()->comment('邮箱');
            $table->string('address', 500)->nullable()->comment('地址');
            $table->text('remark')->nullable()->comment('备注');
            $table->tinyInteger('is_primary')->default(0)->comment('是否主要联系人: 0否,1是');
            $table->timestamps();
            $table->index('service_unit_id')->comment('服务单位索引');
            $table->index('user_id')->comment('用户索引');
            $table->index('is_primary')->comment('主要联系人索引');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_unit_contacts');
    }
};
