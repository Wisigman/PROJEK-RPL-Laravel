<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Mengambil data pembelian milik pengguna yang sedang login
        $purchases = Auth::user()->purchases;

        // Mengembalikan view dengan data pembelian
        return view('history.index', compact('purchases'));
    }
    
    public function store(Request $request)
    {
        $purchase = new Purchase();
        
        // Pastikan user_id diisi dengan ID pengguna yang sedang login
        $purchase->user_id = Auth::id(); // Menyimpan ID pengguna yang sedang login
        $purchase->product_name = $request->product_name;
        $purchase->price = $request->price;
        $purchase->total_amount = $request->price; // Atau sesuai dengan perhitungan total yang benar
        $purchase->status = 'completed'; // Status pembelian, bisa disesuaikan
        $purchase->save();
    
        // Redirect ke halaman riwayat pembelian
        return redirect()->route('history.index');
    }
    

    // Controller untuk menyimpan pembelian setelah berhasil transaksi
    public function storeTransaction(Request $request)
    {
        // Proses pembayaran atau transaksi, kemudian simpan pembelian ke dalam database
        $purchase = new Purchase();
        $purchase->user_id = Auth::id();
        $purchase->product_name = $request->input('product_name'); // Nama produk
        $purchase->price = $request->input('price'); // Harga produk
        $purchase->total_amount = $request->input('total_amount'); // Total harga
        $purchase->status = 'completed'; // Status selesai
        $purchase->save();

        // Redirect ke halaman success setelah berhasil menyimpan data
        return redirect()->route('history.index');
    }

    public function showSuccessPage()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        // Ambil data pembelian pengguna yang sedang login
        $purchases = Auth::user()->purchases; // Mengambil pembelian dari relasi User-Purchase
    
        // Kirimkan data ke view
        return view('purchase.success', compact('purchases'));
    }
     

    public function purchases()
    {
        return $this->hasMany(Purchase::class); // Replace with your actual relationship
    }
}
