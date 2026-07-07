<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_system_user')->default(1)->after('status')->comment('是否系统用户: 0仅通讯录,1可登录');
            $table->tinyInteger('can_view_word')->default(0)->after('is_system_user')->comment('允许查看合同Word附件');
            $table->tinyInteger('can_view_pdf')->default(0)->after('can_view_word')->comment('允许查看合同PDF附件');
            $table->foreignId('service_unit_id')->nullable()->after('vendor_id')->constrained('service_units')->nullOnDelete()->comment('关联服务单位ID');
            $table->index('is_system_user')->comment('系统用户索引');
            $table->index('service_unit_id')->comment('服务单位索引');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['service_unit_id']);
            $table->dropIndex(['is_system_user']);
            $table->dropIndex(['service_unit_id']);
            $table->dropColumn(['is_system_user', 'can_view_word', 'can_view_pdf', 'service_unit_id']);
        });
    }
};
