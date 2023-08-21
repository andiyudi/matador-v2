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
            $table->date('estimation')
            ->nullable()->default(NULL)
            ->after ('receipt');
            $table->date('pic_user')
            ->nullable()->default(NULL)
            ->after ('estimation');
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
        });
    }
};
