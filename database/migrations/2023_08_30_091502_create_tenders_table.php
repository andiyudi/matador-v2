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
            $table->tinyInteger('schedule_type')->nullable()->default(NULL)->comment('0: Normal, 1: Nego, 2: IKP');
            $table->enum('status', ['0', '1', '2', '3'])->default('0'); // 0 = process, 1 = success, 2=cancel, 3=repeat
            $table->string('secretary')->nullable()->default(NULL);
            $table->string('note')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();

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
