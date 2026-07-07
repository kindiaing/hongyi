<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_no', 100)->unique();
            $table->string('contract_name');
            $table->string('party_a_name');
            $table->string('party_a_contact', 100)->nullable();
            $table->string('party_a_phone', 20)->nullable();
            $table->string('party_b_name');
            $table->decimal('total_amount', 15, 2)->default(0.00);
            $table->date('signed_date')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('payment_terms')->nullable();
            $table->text('service_scope')->nullable();
            $table->string('status', 50)->default('draft')->comment('draft草稿,active生效中,expired已到期,terminated已终止');
            $table->text('remark')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
            $table->index('end_date');
            $table->index('party_a_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main_contracts');
    }
};
