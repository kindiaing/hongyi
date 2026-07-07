<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('main_contracts', function (Blueprint $table) {
            $table->foreignId('service_unit_id')->nullable()->after('party_b_name')->constrained('service_units')->nullOnDelete()->comment('关联服务单位ID');
        });
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->foreignId('service_unit_id')->nullable()->after('vendor_id')->constrained('service_units')->nullOnDelete()->comment('关联服务单位ID');
        });
    }

    public function down(): void
    {
        Schema::table('main_contracts', function (Blueprint $table) {
            $table->dropForeign(['service_unit_id']);
            $table->dropColumn('service_unit_id');
        });
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->dropForeign(['service_unit_id']);
            $table->dropColumn('service_unit_id');
        });
    }
};
