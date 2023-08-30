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
            ->after ('official_id');
            $table->integer('user_estimate')
            ->nullable()->default(NULL)
            ->after ('pic_user');
            $table->integer('technique_estimate')
            ->nullable()->default(NULL)
            ->after ('user_estimate');
            $table->integer('deal_nego')
            ->nullable()->default(NULL)
            ->after ('technique_estimate');
            $table->string('information')
            ->nullable()->default(NULL)
            ->after ('deal_nego');
            $table->string('location')
            ->nullable()->default(NULL)
            ->after ('information');
            $table->date('ppoe_accepted')
            ->nullable()->default(NULL)
            ->after ('location');
            $table->date('division_dispostion')
            ->nullable()->default(NULL)
            ->after ('ppoe_accepted');
            $table->date('departement_dispostion')
            ->nullable()->default(NULL)
            ->after ('division_dispostion');

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
            $table->dropColumn('user_estimate');
            $table->dropColumn('technique_estimate');
            $table->dropColumn('deal_nego');
            $table->dropColumn('information');
            $table->dropColumn('location');
            $table->dropColumn('ppoe_accepted');
            $table->dropColumn('division_dispostion');
            $table->dropColumn('departement_dispostion');
        });
    }
};
