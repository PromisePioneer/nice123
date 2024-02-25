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
        Schema::create('distributor_has_barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dist_id');
            $table->unsignedBigInteger('barang_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_has_barang_keluar');
    }
};
