<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('software_id')->nullable()->constrained('software')->nullOnDelete();
            $table->foreignId('personnel_id')->constrained('personnel')->cascadeOnDelete();
            $table->date('shift_date');
            $table->string('shift_type', 50)->comment('白班/夜班/节假日班');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('is_replaced')->default(0);
            $table->foreignId('replaced_by')->nullable()->constrained('personnel')->nullOnDelete();
            $table->string('replace_reason', 255)->nullable();
            $table->tinyInteger('status')->default(1)->comment('0取消,1正常');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('software_id');
            $table->index('personnel_id');
            $table->index('shift_date');
            $table->unique(['software_id', 'personnel_id', 'shift_date', 'shift_type'], 'schedules_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
