<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('main_contracts', function (Blueprint $table) {
            $table->dropIndex(['project_level']);
            $table->dropColumn('project_level');
        });
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->string('project_level', 50)->nullable()->after('maintenance_type')->comment('项目层级：省统建/省建/市建');
            $table->index('project_level');
        });
    }

    public function down(): void
    {
        Schema::table('main_contracts', function (Blueprint $table) {
            $table->string('project_level', 50)->nullable()->after('status')->comment('项目层级：省统建/省建/市建');
            $table->index('project_level');
        });
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->dropIndex(['project_level']);
            $table->dropColumn('project_level');
        });
    }
};
