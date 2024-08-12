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
        Schema::create('tender_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tender_id');
            $table->string('name');
            $table->tinyInteger('type')->comment('0: File Selected Vendor, 1: File Cancelled Tender, 2: File Repeat Tender, 3: File Selected Vendor From Past Tender, 4: File Evaluation Company, 5: File Evaluation Vendor, 6: File Rollback Tender');
            $table->string('path');
            $table->string('notes');
            $table->timestamps();

            $table->foreign('tender_id')->references('id')->on('tenders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_files');
    }
};
