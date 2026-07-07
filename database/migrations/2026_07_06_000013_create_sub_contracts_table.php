<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_contract_id')->constrained('main_contracts')->cascadeOnDelete();
            $table->string('contract_no', 100)->unique();
            $table->string('contract_name');
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('contract_type', 50)->comment('software/hardware/infrastructure/integrated');
            $table->decimal('sub_amount', 15, 2)->default(0.00);
            $table->date('signed_date')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('service_scope')->nullable();
            $table->string('sla_level', 50)->nullable();
            $table->text('payment_terms')->nullable();
            $table->string('status', 50)->default('draft');
            $table->text('remark')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('main_contract_id');
            $table->index('vendor_id');
            $table->index('status');
            $table->index('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_contracts');
    }
};
