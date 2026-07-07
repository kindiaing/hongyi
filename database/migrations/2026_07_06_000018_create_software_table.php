<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->string('software_no', 100)->unique();
            $table->string('software_name');
            $table->string('version', 50)->nullable();
            $table->string('deploy_environment', 100)->nullable();
            $table->string('deploy_server', 255)->nullable();
            $table->string('license_info', 500)->nullable();
            $table->foreignId('sub_contract_id')->nullable()->constrained('sub_contracts')->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->date('maintenance_start_date')->nullable();
            $table->date('maintenance_end_date')->nullable();
            $table->string('maintenance_cycle', 50)->nullable();
            $table->string('sla_level', 50)->nullable();
            $table->tinyInteger('is_resident_required')->default(0);
            $table->string('resident_location', 255)->nullable();
            $table->string('resident_cycle', 50)->nullable();
            $table->time('work_start_time')->nullable();
            $table->time('work_end_time')->nullable();
            $table->integer('emergency_response_time')->nullable()->comment('紧急响应时间(分钟)');
            $table->tinyInteger('status')->default(1)->comment('0停用,1运行中,2维护中');
            $table->text('remark')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('sub_contract_id');
            $table->index('vendor_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
