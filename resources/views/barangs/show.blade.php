@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="font-sans bg-cover bg-center">

    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto my-8">
        
        <div class="text-center text-3xl font-bold text-gray-800 mb-8">Detail Barang</div>

        <div class="flex justify-center mb-6">
            @if ($barang->foto_barang)
                <img src="{{ Storage::url('public/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}" class="w-48 h-48 object-cover rounded-lg border-4 border-gray-300">
            @else
                <span class="text-gray-500 italic">Tidak ada gambar</span>
            @endif
        </div>

        <h2 class="text-3xl font-semibold text-gray-800 text-center mb-4">{{ $barang->nama_barang }}</h2>
        <h3 class="text-xl text-gray-800 text-center mb-6">Nama Pengirim: {{ $barang->user->name }}</h3>

        <!-- Tabel untuk menampilkan informasi barang -->
        <table class="min-w-full table-auto border-collapse border border-gray-300 mx-auto mb-8">
            <tbody>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-currency-dollar mr-2 text-blue-500"></i> Harga per Satuan Awal</th>
                    <td class="p-4 text-gray-700">Rp.{{ number_format($barang->harga_barang - 1000, 2, ',', '.') }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-tag mr-2 text-blue-500"></i> Harga per Satuan Jual</th>
                    <td class="p-4 text-gray-700">Rp.{{ number_format($barang->harga_barang, 2, ',', '.') }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-box mr-2 text-blue-500"></i> Jumlah Barang Awal</th>
                    <td class="p-4 text-gray-700">{{ $barang->jumlah_barang_awal }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-cart-check mr-2 text-blue-500"></i> Jumlah Barang Terjual</th>
                    <td class="p-4 text-gray-700">{{ $barang->jumlah_barang_awal - $jumlahBarangSisa }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-box-seam mr-2 text-blue-500"></i> Jumlah Barang Sisa</th>
                    <td class="p-4 text-gray-700">{{ $jumlahBarangSisa }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-graph-up mr-2 text-blue-500"></i> Total Harga Terjual</th>
                    <td class="p-4 text-gray-700">Rp.{{ number_format($totalHargaTerjual, 2, ',', '.') }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-wallet2 mr-2 text-blue-500"></i> Hasil Untuk Pengirim</th>
                    <td class="p-4 text-green-600 font-semibold">Rp.{{ number_format($totalHasilPengiriman, 2, ',', '.') }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-trophy mr-2 text-blue-500"></i> Keuntungan PKK</th>
                    <td class="p-4 text-green-600 font-semibold">Rp.{{ number_format($keuntunganPKK, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 font-semibold text-gray-700"><i class="bi bi-plus-circle mr-2 text-blue-500"></i> Keuntungan RPL (500 per Barang)</th>
                    <td class="p-4 text-green-600 font-semibold">Rp.{{ number_format($jumlahBarangTerjual * 500, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <div class="text-center mt-8">
            <a href="{{ route('barangs.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-blue-600 transition-transform duration-300 relative hover:scale-105 no-underline">
                Kembali
            </a>
        </div>
    </div>

</body>

@endsection