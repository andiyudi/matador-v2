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
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('name');
            $table->date('receipt');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('official_id');
            $table->unsignedBigInteger('business_id')->nullable()->default(NULL);
            $table->string('pic_user')->nullable()->default(NULL);
            $table->string('estimation')->nullable()->default(NULL);
            $table->enum('status', ['0', '1', '2'])->default('0'); // 0 = process, 1 = success, 2=cancel
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurements');
    }
};
