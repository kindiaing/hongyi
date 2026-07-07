<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_renewals', function (Blueprint $table) {
            $table->id();
            $table->string('contract_type', 20);
            $table->unsignedBigInteger('contract_id');
            $table->string('renewal_no', 100);
            $table->date('previous_end_date');
            $table->date('new_start_date');
            $table->date('new_end_date');
            $table->decimal('new_amount', 15, 2)->default(0.00);
            $table->text('renewal_reason')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0待审批,1已生效,2已驳回');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['contract_type', 'contract_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_renewals');
    }
};
