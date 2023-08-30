<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('business_partner_tender', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tender_id');
            $table->unsignedBigInteger('business_partner_id');
            $table->enum('is_selected', ['0', '1'])->default('0'); // 0: not selected and 1: selected
            $table->time('negotiation_time')->nullable()->default(NULL);
            //company to vendor
            $table->enum('evaluation', ['0', '1'])->nullable()->default(NULL); // 0: bad evaluation and 1: good evaluation
            //vendor to company
            $table->enum('value_cost', ['0', '1', '2'])->nullable()->default(NULL); // 0: 0<100JT, 1: 100JT<1M, 2: >1M
            $table->enum('contract_order', ['0', '1', '2'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama
            $table->enum('work_implementation', ['0', '1', '2'])->nullable()->default(NULL); // 0: mudah, 1: sulit, 2: sangat sulit
            $table->enum('pre_handover', ['0', '1', '2', '3'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama, 3: tidak ada PHO
            $table->enum('final_handover', ['0', '1', '2', '3'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama, 3: tidak ada FHO
            $table->enum('invoice_payment', ['0', '1', '2'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama
            $table->timestamps();

            $table->foreign('tender_id')->references('id')->on('tenders')->onDelete('cascade');
            $table->foreign('business_partner_id')->references('id')->on('business_partner')->onDelete('cascade');

            $table->unique(['tender_id', 'business_partner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_partner_tender');
    }
};
