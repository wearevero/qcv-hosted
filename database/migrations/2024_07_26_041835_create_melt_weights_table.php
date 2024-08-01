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
        Schema::create('melt_weights', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->unsignedBigInteger('on_status');
            $table->float('alloy')->default(0);
            $table->float('origin')->default(0);
            $table->float('pohon')->default(0);
            $table->float('potongan')->default(0);
            $table->float('total_weight')->default(0);
            $table->float('box_weight')->default(0);
            $table->float('granule_weight')->default(0);
            $table->string('by_person')->default('Test Admin');
            $table->timestamp('recorded_at')->useCurrent();
            $table->foreign('barcode')->references('barcode')->on('melt_packages');
            $table->foreign('on_status')->references('id')->on('history_statuses');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('melt_weights');
    }
};
