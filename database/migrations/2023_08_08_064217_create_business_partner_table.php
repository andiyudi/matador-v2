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
        Schema::create('business_partner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('partner_id');
            $table->date('blacklist_at')->nullable()->default(NULL);
            $table->date('can_whitelist_at')->nullable()->default(NULL);
            $table->date('whitelist_at')->nullable()->default(NULL);
            $table->enum('is_blacklist', ['0','1'])->default('0'); // 0=not blacklisted, 1=blacklisted
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');

            $table->unique(['business_id', 'partner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_partner');
    }
};
