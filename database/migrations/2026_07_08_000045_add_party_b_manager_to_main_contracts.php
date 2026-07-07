<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('main_contracts', function (Blueprint $table) {
            $table->string('party_b_manager_name', 100)->nullable()->after('party_b_name')->comment('乙方管理人姓名');
            $table->string('party_b_manager_phone', 20)->nullable()->after('party_b_manager_name')->comment('乙方管理人电话');
        });
    }

    public function down(): void
    {
        Schema::table('main_contracts', function (Blueprint $table) {
            $table->dropColumn(['party_b_manager_name', 'party_b_manager_phone']);
        });
    }
};
