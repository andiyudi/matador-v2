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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('domicility');
            $table->string('area');
            $table->string('director');
            $table->string('phone');
            $table->string('email');
            $table->string('capital');
            $table->string('reference');
            $table->enum('grade', ['0', '1', '2']); //0:kecil, 1:menengah, 2: besar
            $table->date('join_date');
            $table->enum('status', ['0', '1', '2'])->default('0'); //0:registered, 1:active, 2:inactive
            $table->date('expired_at')->nullable()->default(date('Y') . '-12-31');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
