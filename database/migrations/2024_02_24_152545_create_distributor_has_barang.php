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
        Schema::create('distributor_has_barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dist_id');
            $table->unsignedBigInteger('barangmasuk_id');
            $table->timestamps();

            $table->foreign('dist_id')->references('id')->on('distributor')->onDelete('cascade');
            $table->foreign('barangmasuk_id')->references('barang_id')->on('barang_masuk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_has_barang');
    }
};
