<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('contract_type', 20)->comment('main主合同,sub分包合同');
            $table->unsignedBigInteger('contract_id');
            $table->string('file_name');
            $table->string('file_path', 500);
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('file_type', 50);
            $table->string('description', 500)->nullable();
            $table->tinyInteger('is_sealed')->default(0)->comment('是否盖章');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['contract_type', 'contract_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_attachments');
    }
};
