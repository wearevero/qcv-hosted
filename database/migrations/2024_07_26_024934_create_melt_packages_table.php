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
        Schema::create('melt_packages', function (Blueprint $table) {
            $table->string('barcode')->unique();
            $table->json('original')->nullable();
            $table->json('alloy')->nullable();
            $table->json('potongan')->nullable();
            $table->json('pohon')->nullable();
            $table->float('initial_weight')->default(0);
            $table->float('final_weight')->default(0);
            $table->float('granule_weight')->default(0);
            $table->string('by_person')->default('Test Admin');
            $table->unsignedBigInteger('record_id')->autoIncrement();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('melt_packages');
    }
};
