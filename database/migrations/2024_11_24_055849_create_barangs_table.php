<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id(); // Kolom id, primary key
            $table->unsignedBigInteger('user_id'); // Relasi ke tabel users
            $table->string('nama_barang', 255);
            $table->enum('kategori_barang', ['makanan', 'kerajinan'])->default('makanan');
            $table->integer('harga_barang');
            $table->integer('jumlah_barang');
            $table->string('foto_barang', 255);
            $table->decimal('total', 10, 2)->nullable();
            $table->text('keterangan_barang')->nullable();
            $table->timestamps();
            $table->decimal('harga_pokok', 10, 2)->default(0.00);
            $table->decimal('keuntungan_per_unit', 10, 2)->default(0.00);
            $table->integer('jumlah_barang_awal')->default(0);
            $table->integer('jumlah_terjual')->default(0);
            $table->decimal('total_harga_terjual', 15, 2)->default(0.00);
            $table->decimal('keuntungan', 15, 2)->default(0.00);
            $table->integer('stok_tersisa')->default(0);

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
