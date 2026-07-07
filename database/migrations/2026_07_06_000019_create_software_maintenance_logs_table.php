<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software_maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('software_id')->constrained('software')->cascadeOnDelete();
            $table->date('maintenance_date');
            $table->string('maintenance_type', 50)->comment('日常/故障/升级/优化');
            $table->text('description')->nullable();
            $table->text('result')->nullable();
            $table->integer('duration')->nullable()->comment('耗时(分钟)');
            $table->foreignId('personnel_id')->nullable()->constrained('personnel')->nullOnDelete();
            $table->json('attachments')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('software_id');
            $table->index('maintenance_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software_maintenance_logs');
    }
};
