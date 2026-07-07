<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->string('maintenance_type', 50)
                ->nullable()
                ->after('contract_type')
                ->comment('运维类型: 原建设方驻场/原建设方远程运维/自主巡检/自主运维驻场/购买服务');
            $table->index('maintenance_type');
        });
    }

    public function down(): void
    {
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->dropIndex(['maintenance_type']);
            $table->dropColumn('maintenance_type');
        });
    }
};
