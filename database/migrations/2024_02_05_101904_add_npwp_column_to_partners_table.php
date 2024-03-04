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
        Schema::table('partners', function (Blueprint $table) {
            $table->string('npwp')->nullable()->default(NULL)->after('name');
            $table->date('start_deed')->nullable()->default(NULL)->after('expired_at');
            $table->date('end_deed')->nullable()->default(NULL)->after('start_deed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('npwp');
            $table->dropColumn('start_deed');
            $table->dropColumn('end_deed');
        });
    }
};
