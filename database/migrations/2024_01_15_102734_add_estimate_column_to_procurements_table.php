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
            $table->string('information')->nullable()->default(NULL)->after('deal_nego');
            // $table->date('ppoe_accepted')->nullable()->default(NULL)->after('information');
            // $table->date('division_disposition')->nullable()->default(NULL)->after('ppoe_accepted');
            // $table->date('departement_disposition')->nullable()->default(NULL)->after('division_disposition');
            // $table->date('return_to_user')->nullable()->default(NULL)->after('departement_disposition');
            // $table->string('cancellation_memo')->nullable()->default(NULL)->after('return_to_user');
            // $table->string('op_number')->nullable()->default(NULL)->after('cancellation_memo');
            // $table->string('contract_number')->nullable()->default(NULL)->after('op_number');
            // $table->date('contract_date')->nullable()->default(NULL)->after('contract_number');
            // $table->date('director_approval')->nullable()->default(NULL)->after('contract_date');
            // $table->date('disposition_second_tender')->nullable()->default(NULL)->after('director_approval');
            // $table->date('renegotiation_result')->nullable()->default(NULL)->after('disposition_second_tender');
            // $table->date('legal_accept')->nullable()->default(NULL)->after('renegotiation_result');
            // $table->date('general_accept')->nullable()->default(NULL)->after('legal_accept');
            // $table->date('user_accept')->nullable()->default(NULL)->after('general_accept');
            // $table->date('vendor_accept')->nullable()->default(NULL)->after('user_accept');
            // $table->date('director_accept')->nullable()->default(NULL)->after('vendor_accept');
            // $table->date('contract_from_legal')->nullable()->default(NULL)->after('director_accept');
            // $table->date('contract_to_vendor')->nullable()->default(NULL)->after('contract_from_legal');
            // $table->date('contract_to_user')->nullable()->default(NULL)->after('contract_to_vendor');
            // $table->date('input_sap')->nullable()->default(NULL)->after('contract_to_user');
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
            $table->dropColumn('information');
            // $table->dropColumn('ppoe_accepted');
            // $table->dropColumn('division_disposition');
            // $table->dropColumn('departement_disposition');
            // $table->dropColumn('return_to_user');
            // $table->dropColumn('cancellation_memo');
            // $table->dropColumn('op_number');
            // $table->dropColumn('contract_number');
            // $table->dropColumn('contract_date');
            // $table->dropColumn('director_approval');
            // $table->dropColumn('disposition_second_tender');
            // $table->dropColumn('renegotiation_result');
            // $table->dropColumn('legal_accept');
            // $table->dropColumn('general_accept');
            // $table->dropColumn('user_accept');
            // $table->dropColumn('vendor_accept');
            // $table->dropColumn('director_accept');
            // $table->dropColumn('contract_from_legal');
            // $table->dropColumn('contract_to_vendor');
            // $table->dropColumn('contract_to_user');
            // $table->dropColumn('input_sap');
        });
    }
};
