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
        Schema::create('business_partner_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_partner_id');
            $table->string('name');
            $table->tinyInteger('type')->comment('0: Whitelist, 1: Blacklist');
            $table->string('path');
            $table->string('notes');
            $table->timestamps();

            $table->foreign('business_partner_id')->references('id')->on('business_partner')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_partner_files');
    }
};
