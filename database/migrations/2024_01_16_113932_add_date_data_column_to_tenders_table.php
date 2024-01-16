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
        Schema::table('tenders', function (Blueprint $table) {
            $table->date('report_nego_result')->nullable()->default(NULL)->after('note');
            $table->date('aanwijzing')->nullable()->default(NULL)->after('report_nego_result');
            $table->date('open_tender')->nullable()->default(NULL)->after('aanwijzing');
            $table->date('review_technique_in')->nullable()->default(NULL)->after('open_tender');
            $table->date('review_technique_out')->nullable()->default(NULL)->after('review_technique_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn('report_nego_result');
            $table->dropColumn('aanwijzing');
            $table->dropColumn('open_tender');
            $table->dropColumn('review_technique_in');
            $table->dropColumn('review_technique_out');
        });
    }
};
