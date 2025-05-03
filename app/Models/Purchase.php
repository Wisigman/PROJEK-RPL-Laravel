<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Tambahkan import ini
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class Purchase extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the purchase.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fungsi index ini seharusnya berada di controller, bukan di model
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Mengambil data pembelian milik pengguna yang sedang login
        $purchases = Auth::user()->purchases;

        return view('history.index', compact('purchases'));
    }

    protected $fillable = ['user_id', 'product_name', 'price']; // Pastikan kolom yang diizinkan untuk diisi ada di sini
    protected $guarded = []; // Artinya, semua kolom dapat diisi
}
