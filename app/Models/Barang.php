<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori_barang',
        'harga_barang',
        'harga_pokok',
        'jumlah_barang',
        'jumlah_barang_awal',
        'jumlah_terjual',
        'foto_barang',
        'keterangan_barang',
        'user_id'
    ];
    
    // Pastikan harga pokok dan jumlah barang terjual didefinisikan
    // Di mana harga_pokok adalah biaya produksi atau pembelian barang
    public function getHargaBarangAttribute($value)
    {
        // Menambahkan pajak Rp. 1000 jika ingin dihitung
        $hargaDenganRetribusi = $value + 1000; // Harga barang + pajak
    
        // Anda bisa menambahkan logika lain jika ada kebutuhan untuk menghitung biaya lain, seperti jasa web
        $hargaDenganJasaWeb = $hargaDenganRetribusi + 500; // Harga setelah jasa web
    
        return $hargaDenganJasaWeb; // Mengembalikan harga akhir setelah pajak dan jasa web
    }
    
    // Di model Barang.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Barang.php
    public function colors()
    {
        return $this->hasMany(Color::class);
    }

}
