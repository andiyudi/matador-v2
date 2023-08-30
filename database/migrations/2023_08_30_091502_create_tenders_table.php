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
            $table->date('field_review')->nullable()->default(NULL);
            $table->date('tender_price_offer')->nullable()->default(NULL);
            $table->date('verify_price_offer')->nullable()->default(NULL);
            $table->date('submit_document')->nullable()->default(NULL);
            $table->date('price_negotiation')->nullable()->default(NULL);
            $table->date('nego_evaluation')->nullable()->default(NULL);
            $table->date('report_nego_result')->nullable()->default(NULL);
            $table->date('director_approval')->nullable()->default(NULL);
            $table->date('approval_vendor_result')->nullable()->default(NULL);
            $table->date('purchase_order_contract')->nullable()->default(NULL);
            $table->date('review_technique_in')->nullable()->default(NULL);
            $table->date('review_technique_out')->nullable()->default(NULL);
            $table->date('disposition_second_tender')->nullable()->default(NULL);
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
