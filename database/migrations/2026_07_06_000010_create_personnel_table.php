<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 100);
            $table->string('id_card', 18)->nullable();
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->tinyInteger('gender')->nullable()->comment('0女,1男');
            $table->date('birth_date')->nullable();
            $table->string('position', 100)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->date('entry_date')->nullable();
            $table->date('leave_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0离职,1在职,2休假');
            $table->tinyInteger('is_resident')->default(0)->comment('是否驻场');
            $table->string('resident_location', 255)->nullable();
            $table->time('work_start_time')->nullable();
            $table->time('work_end_time')->nullable();
            $table->string('emergency_contact', 100)->nullable();
            $table->string('emergency_phone', 20)->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('vendor_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('is_resident');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};
