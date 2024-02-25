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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->unsignedBigInteger('dist_id');
            $table->foreign('dist_id')
                ->references('id')
                ->on('distributor')
                ->onDelete('cascade');
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')
                ->references('id')
                ->on('barang')
                ->onDelete('cascade');
            $table->date('tanggal');
            $table->double('qty');
            $table->double('harga_jual');
            $table->double('total');
            $table->string('user_id');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
