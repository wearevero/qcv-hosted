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
        Schema::create('melt_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->unsignedBigInteger('status');
            $table->string('by_person')->default('Test Admin');
            $table->enum('edited', ['1', '0'])->default('0');
            $table->timestamp('recorded_at')->useCurrent();
            $table->foreign('barcode')->references('barcode')->on('melt_packages');
            $table->foreign('status')->references('id')->on('history_statuses');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('melt_statuses');
    }
};
