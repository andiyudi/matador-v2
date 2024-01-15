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
            $table->double('user_estimate')->nullable()->default(NULL)->after('estimation');
            $table->double('technique_estimate')->nullable()->default(NULL)->after('user_estimate');
            $table->double('deal_nego')->nullable()->default(NULL)->after('technique_estimate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurements', function (Blueprint $table) {
            $table->dropColumn('user_estimate');
            $table->dropColumn('technique_estimate');
            $table->dropColumn('deal_nego');
        });
    }
};
