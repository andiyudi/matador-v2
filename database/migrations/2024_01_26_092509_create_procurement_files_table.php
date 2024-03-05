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
        Schema::create('procurement_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procurement_id');
            $table->string('name');
            // $table->tinyInteger('type')->comment('0: User Document, 1: Procurement Document, 2: Tender Document, 3: Decision Document, 4: Contract Document, 5: Other Document');
            $table->unsignedBigInteger('definition_id');
            $table->string('path');
            $table->string('notes');
            $table->timestamps();

            $table->foreign('procurement_id')->references('id')->on('procurements')->onDelete('cascade');
            $table->foreign('definition_id')->references('id')->on('definitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_files');
    }
};
