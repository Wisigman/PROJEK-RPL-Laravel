<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        ($barangs); // Untuk memastikan apakah data ada
        return view('barangs.index', compact('barangs'));
    }   

    public function create()
    {
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'supplier')) {
            return view('barangs.create');
        }
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');        
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_barang' => 'required|in:makanan,kerajinan',
            'harga_barang' => 'required|numeric',
            'jumlah_barang' => 'required|numeric',
            'foto_barang' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'keterangan_barang' => 'nullable|string|max:1000',
        ]);
    
        // Jika pengguna memiliki peran yang benar
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'supplier')) {
            $validated['user_id'] = Auth::id(); // Menyimpan ID pengguna yang menambahkan barang
            
            // Menghitung harga pokok
            $hargaPokok = $validated['harga_barang'] - 1000;
            $validated['harga_pokok'] = $hargaPokok;
    
            // Menyimpan jumlah barang awal
            $validated['jumlah_barang_awal'] = $validated['jumlah_barang'];
            $validated['jumlah_terjual'] = 0;
    
            // Menyimpan foto barang
            if ($request->hasFile('foto_barang')) {
                $validated['foto_barang'] = $request->file('foto_barang')->store('images', 'public');
            }
    
            // Menyimpan barang ke database
            Barang::create($validated);
    
            return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan!');
        }
    
        abort(403, 'Anda tidak memiliki izin untuk menambah barang.');
    }    
    
    public function edit(Barang $barang)
    {
        // Log informasi untuk debugging
        Log::info('User role: ' . Auth::user()->role);
        Log::info('User ID: ' . Auth::id());
        Log::info('Barang user ID: ' . $barang->user_id);

        // Cek apakah user memiliki izin untuk mengedit barang
        if (Auth::check() && (Auth::user()->role === 'admin' || (Auth::user()->role === 'supplier' && Auth::id() === $barang->user_id))) {
            return view('barangs.edit', compact('barang'));
        }

        // Jika tidak memiliki izin, tampilkan pesan error
        abort(403, 'Anda tidak memiliki izin untuk mengedit barang ini.');
    }


    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $barang->user_id) {
            return redirect()->route('barangs.index')->with('error', 'Anda tidak memiliki izin untuk menghapus barang ini.');
        }
        $barang->delete();
        return redirect()->route('barangs.index')->with('status', 'Barang berhasil dihapus.');
    }

    public function update(Request $request, Barang $barang)
    {
        // Validasi input yang diterima
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_barang' => 'required|in:makanan,kerajinan',
            'harga_barang' => 'required|numeric|min:0',
            'jumlah_barang' => 'required|integer|min:1',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan_barang' => 'nullable|string|max:1000',
        ]);

        // Memeriksa apakah pengguna memiliki peran yang benar untuk mengupdate barang
        if (Auth::check() && (Auth::user()->role === 'admin' || (Auth::user()->role === 'supplier' && Auth::id() === $barang->user_id))) {

            // Pastikan harga barang valid
            $hargaBarang = $validated['harga_barang'];

            // Menghitung harga pokok sebelum pajak (Harga barang dikurangi pajak)
            $hargaPokok = $hargaBarang - 1500;  // Asumsi pajak sebesar 1500

            // Menghitung harga setelah retribusi (harga barang ditambah retribusi)
            $hargaDenganRetribusi = $hargaBarang + 1000;  // Asumsi retribusi Rp1000

            // Menghitung harga setelah jasa web (harga barang ditambah jasa web)
            $hargaDenganJasaWeb = $hargaDenganRetribusi + 500;  // Biaya jasa web Rp500

            // Menyimpan harga pokok, harga dengan retribusi, dan harga dengan jasa web
            $validated['harga_pokok'] = $hargaPokok;
            $validated['harga_dengan_retribusi'] = $hargaDenganRetribusi;
            $validated['harga_dengan_web'] = $hargaDenganJasaWeb;

            // Mengupdate jumlah barang awal
            $validated['jumlah_barang_awal'] = $validated['jumlah_barang'];  // Set jumlah barang sebagai jumlah awal

            // Jika ada foto yang diupload, simpan foto baru dan hapus yang lama
            if ($request->hasFile('foto_barang')) {
                // Menghapus foto lama jika ada
                if ($barang->foto_barang) {
                    Storage::delete('public/' . $barang->foto_barang);
                }

                // Menyimpan foto baru
                $validated['foto_barang'] = $request->file('foto_barang')->store('images', 'public');
            } else {
                // Jika tidak ada foto yang diupload, hapus data foto dari array validated
                unset($validated['foto_barang']);
            }            

            // Mengupdate data barang
            $barang->update($validated);

            // Redirect kembali dengan pesan sukses
            return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui!');
        }

        // Jika pengguna tidak memiliki izin, tampilkan halaman error 403
        abort(403, 'Anda tidak memiliki izin untuk memperbarui barang ini.');
    }

    public function beli(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        // Validasi jumlah pembelian
        $jumlah = $request->input('jumlah');  // Ambil jumlah yang dibeli
        if ($jumlah > $barang->jumlah_barang) {
            return redirect()->back()->with('error', 'Jumlah yang dibeli melebihi stok yang tersedia.');
        }

        // Menghitung total harga
        $totalHarga = $barang->harga_barang * $jumlah;
        $barang->jumlah_barang -= $jumlah;
        $barang->save();

        return view('barangs.beli', compact('barang', 'jumlah', 'totalHarga'));
    }

    public function beliMassa(Request $request)
{
    // Ambil data barang yang dibeli dan jumlahnya
    $barangIds = array_keys($request->barang); // Ambil ID barang yang dipilih
    $barangs = Barang::whereIn('id', $barangIds)->get();

    // Simpan data pembelian sementara untuk ditampilkan di halaman konfirmasi
    $pembelian = [];
    foreach ($barangs as $barang) {
        $jumlah = $request->barang[$barang->id];
        if ($jumlah > 0) {
            $pembelian[] = [
                'barang' => $barang,
                'jumlah' => $jumlah,
                'total' => $barang->harga_barang * $jumlah
            ];
        }
    }

    // Kirim data pembelian ke halaman konfirmasi
    return view('beli', compact('pembelian'));
}

public function prosesPembelian(Request $request)
{
    // Ambil data pembelian yang telah disetujui dari sesi
    $pembelian = session('pembelian');

    // Pastikan data pembelian ada
    if (!$pembelian) {
        return redirect()->route('barangs.index')->with('error', 'Tidak ada barang yang dibeli.');
    }

    // Jalankan proses dalam database transaction
    DB::transaction(function () use ($pembelian) {
        foreach ($pembelian as $item) {
            $barang = $item['barang'];
            $jumlah = $item['jumlah'];
            $total = $item['total'];

            // Menghitung keuntungan
            $keuntungan = ($barang->harga_barang - $barang->harga_pokok) * $jumlah;

            // Periksa stok barang
            if ($barang->jumlah_barang < $jumlah) {
                throw new \Exception('Jumlah barang tidak cukup.');
            }

            // Update stok barang
            $barang->jumlah_barang -= $jumlah;
            $barang->jumlah_terjual += $jumlah;
            $barang->save();

            // Simpan transaksi
            Transaksi::create([
                'user_id' => Auth::id(),
                'barang_id' => $barang->id,
                'jumlah' => $jumlah,
                'total_harga' => $total,
                'keuntungan' => $keuntungan,
                'tanggal_transaksi' => now(),
            ]);
        }
    });

    // Kosongkan sesi pembelian
    session()->forget('pembelian');

    return redirect()->route('barangs.index')->with('success', 'Pembelian berhasil diproses!');
}

public function tambahKeKeranjang(Request $request)
{
    $barang = Barang::find($request->id);
    
    // Pastikan barang yang tersedia cukup
    if ($barang->jumlah_barang >= $request->quantity) {
        // Mengurangi jumlah barang yang ada dan menambah jumlah terjual
        $barang->jumlah_barang -= $request->quantity; // Mengurangi jumlah barang yang ada
        $barang->jumlah_terjual += $request->quantity; // Menambah jumlah barang terjual
        $barang->save();
    } else {
        return redirect()->back()->with('error', 'Jumlah barang tidak cukup!');
    }

    // Logika untuk menambah ke keranjang (misalnya menggunakan session atau database untuk keranjang)
    // $keranjang = session()->get('keranjang', []);
    // $keranjang[$barang->id] = $request->quantity;
    // session()->put('keranjang', $keranjang);

    return redirect()->route('keranjang.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
}

public function show($id)
{
    $barang = Barang::findOrFail($id);

    // Mengambil jumlah barang yang terjual dan menghitung sisa barang berdasarkan jumlah_barang_awal
    $jumlahBarangTerjual = $barang->jumlah_barang_awal - $barang->jumlah_barang;

    // Jika jumlah barang terjual adalah 0, berarti tidak ada yang membeli barang tersebut
    if ($jumlahBarangTerjual <= 0) {
        $totalHargaTerjual = 0;
        $keuntunganPKK = 0;
        $totalHasilPengiriman = 0;
    } else {
        // Menghitung total harga terjual (jumlah terjual * harga jual)
        $totalHargaTerjual = $jumlahBarangTerjual * $barang->harga_barang;

        // Menghitung keuntungan PKK (misalnya 1000 per barang yang terjual)
        $keuntunganPKK = $jumlahBarangTerjual * 1000;

        // Menghitung hasil untuk pengirim (harga satuan awal * jumlah barang terjual)
        $totalHasilPengiriman = $jumlahBarangTerjual * ($barang->harga_barang - 1000);

        // Mengurangi keuntungan tambahan sebesar 500 per barang dari hasil pengirim
        $totalHasilPengiriman -= $jumlahBarangTerjual * 500;
    }

    // Menghitung jumlah barang sisa
    $jumlahBarangSisa = $barang->jumlah_barang_awal - $jumlahBarangTerjual;

    // Kirimkan semua variabel yang diperlukan ke view
    return view('barangs.show', compact(
        'barang',
        'jumlahBarangTerjual',
        'jumlahBarangSisa',
        'totalHargaTerjual',
        'keuntunganPKK',
        'totalHasilPengiriman'
    ));
}
}