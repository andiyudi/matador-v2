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
        Schema::table('business_partner_tender', function (Blueprint $table) {
            $table->date('document_pickup')->nullable()->default(NULL)->after('end_hour');
            $table->date('aanwijzing_date')->nullable()->default(NULL)->after('document_pickup');
            $table->double('quotation')->nullable()->default(NULL)->after('aanwijzing_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_partner_tender', function (Blueprint $table) {
            $table->dropColumn('document_pickup');
            $table->dropColumn('aanwijzing_date');
            $table->dropColumn('quotation');
        });
    }
};
