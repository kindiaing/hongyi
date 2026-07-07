<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hardware_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_no', 100)->unique();
            $table->string('device_name');
            $table->string('device_type', 50)->comment('服务器/UPS/交换机/防火墙/存储/空调/配电柜');
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_no', 100)->nullable();
            $table->text('specification')->nullable();
            $table->string('location', 255)->nullable();
            $table->foreignId('sub_contract_id')->nullable()->constrained('sub_contracts')->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->date('purchase_date')->nullable();
            $table->string('supplier', 255)->nullable();
            $table->decimal('purchase_amount', 15, 2)->nullable();
            $table->integer('warranty_period')->nullable()->comment('质保期(月)');
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('scrap_date')->nullable();
            $table->string('maintenance_cycle', 50)->nullable()->comment('月/季/半年/年');
            $table->date('next_maintenance_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0报废,1在用,2维修中,3闲置');
            $table->string('qrcode')->nullable();
            $table->text('remark')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('device_type');
            $table->index('sub_contract_id');
            $table->index('vendor_id');
            $table->index('status');
            $table->index('expiry_date');
            $table->index('next_maintenance_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hardware_devices');
    }
};
