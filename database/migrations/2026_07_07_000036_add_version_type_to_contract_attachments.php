<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contract_attachments', function (Blueprint $table) {
            $table->string('version_type', 20)
                ->nullable()
                ->after('file_type')
                ->comment('附件版本类型: word电子版, pdf_sealed盖章版');
            $table->index('version_type')->comment('附件版本类型索引');
        });
    }

    public function down(): void
    {
        Schema::table('contract_attachments', function (Blueprint $table) {
            $table->dropIndex(['version_type']);
            $table->dropColumn('version_type');
        });
    }
};
