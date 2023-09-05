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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procurement_id');
            $table->date('send_tender_document')->nullable()->default(NULL);
            $table->date('tender_invitation')->nullable()->default(NULL);
            $table->date('aanwijzing')->nullable()->default(NULL);
            $table->date('price_negotiation')->nullable()->default(NULL);
            $table->date('review_technique_in')->nullable()->default(NULL);
            $table->date('review_technique_out')->nullable()->default(NULL);
            $table->date('disposition_second_tender')->nullable()->default(NULL);
            $table->date('renegotiation_result')->nullable()->default(NULL);
            $table->date('tender_result_report')->nullable()->default(NULL);
            $table->date('director_approval')->nullable()->default(NULL);
            $table->date('legal_approve')->nullable()->default(NULL);
            $table->date('division_approve')->nullable()->default(NULL);
            $table->date('user_approve')->nullable()->default(NULL);
            $table->date('vendor_approve')->nullable()->default(NULL);
            $table->date('director_sign')->nullable()->default(NULL);
            $table->date('legal_send_contract')->nullable()->default(NULL);
            $table->date('send_vendor_contract')->nullable()->default(NULL);
            $table->date('send_user_contract')->nullable()->default(NULL);
            $table->date('input_sap')->nullable()->default(NULL);
            $table->date('report_nego_result')->nullable()->default(NULL);
            $table->date('tender_date')->nullable()->default(NULL);
            $table->string('secretary')->nullable()->default(NULL);
            $table->string('number')->nullable()->default(NULL);
            $table->enum('status', ['0', '1', '2', '3'])->default('0'); // 0 = process, 1 = success, 2=cancel, 3=repeat
            $table->timestamps();

            $table->foreign('procurement_id')->references('id')->on('procurements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
