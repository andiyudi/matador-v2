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
        Schema::table('business_partner', function (Blueprint $table) {
            $table->date('blacklist_at')->nullable()->default(NULL)->after ('is_blacklist');
            $table->date('can_whitelist_at')->nullable()->default(NULL)->after ('blacklist_at');
            $table->date('whitelist_at')->nullable()->default(NULL)->after ('can_whitelist_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_partner', function (Blueprint $table) {
            $table->dropColumn('blacklist_at');
            $table->dropColumn('can_whitelist_at');
            $table->dropColumn('whitelist_at');
        });
    }
};
