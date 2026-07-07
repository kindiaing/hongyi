<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->tinyInteger('attachment_visible')->default(1)->after('status')->comment('附件是否展示: 0隐藏,1展示');
            $table->index('attachment_visible')->comment('附件可见索引');
        });
    }

    public function down(): void
    {
        Schema::table('sub_contracts', function (Blueprint $table) {
            $table->dropIndex(['attachment_visible']);
            $table->dropColumn('attachment_visible');
        });
    }
};
