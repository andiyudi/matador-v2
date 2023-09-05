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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tender_id');
            $table->string('activity');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('category');
            $table->tinyInteger('type')->comment('0: IKP, 1: Aanwijzing+Nego, 2:Normal');
            $table->timestamps();

            $table->foreign('tender_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
