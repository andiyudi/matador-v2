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
        Schema::table('procurements', function (Blueprint $table) {
            $table->string('estimation')
            ->nullable()->default(NULL)
            ->after ('receipt');
            $table->string('pic_user')
            ->nullable()->default(NULL)
            ->after ('estimation');
            $table->unsignedBigInteger('business_id')
            ->nullable()->default(NULL)
            ->after ('pic_user');

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurements', function (Blueprint $table) {
            $table->dropColumn('estimation');
            $table->dropColumn('pic_user');
            $table->dropColumn('business_id');
        });
    }
};
