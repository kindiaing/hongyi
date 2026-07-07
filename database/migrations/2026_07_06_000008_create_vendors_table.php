<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name', 100)->nullable();
            $table->string('unified_code', 50)->nullable()->unique();
            $table->string('type', 50)->comment('软件运维商/硬件运维商/机房建设商/综合服务商');
            $table->string('qualification_level', 50)->nullable();
            $table->string('legal_person', 100)->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_account', 100)->nullable();
            $table->tinyInteger('cooperation_status')->default(1)->comment('0终止,1合作中,2暂停');
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('type');
            $table->index('cooperation_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
