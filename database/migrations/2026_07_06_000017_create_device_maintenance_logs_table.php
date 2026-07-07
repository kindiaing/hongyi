<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('hardware_devices')->cascadeOnDelete();
            $table->date('maintenance_date');
            $table->string('maintenance_type', 50)->comment('定期/故障/升级');
            $table->text('description')->nullable();
            $table->text('result')->nullable();
            $table->decimal('cost', 15, 2)->nullable();
            $table->string('service_provider', 255)->nullable();
            $table->string('technician', 100)->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->json('attachments')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('device_id');
            $table->index('maintenance_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_maintenance_logs');
    }
};
