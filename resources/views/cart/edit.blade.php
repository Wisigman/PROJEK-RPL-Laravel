@extends('layouts.app')

@section('title', 'Edit Barang di Keranjang')

@section('content')
<div class="container mx-auto px-6 py-12 flex justify-center items-center min-h-screen">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-2xl space-y-8">
        <h2 class="text-4xl font-bold text-center text-gray-800">Edit Barang di Keranjang</h2>

        <form action="{{ route('cart.update', $id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Foto Barang -->
            <div class="flex justify-center">
                <img src="{{ $item['foto_barang'] ? asset('storage/' . $item['foto_barang']) : 'https://via.placeholder.com/150' }}" 
                     alt="{{ $item['name'] }}" 
                     class="w-48 h-48 object-cover rounded-lg shadow-md border-2 border-gray-200">
            </div>

            <!-- Detail Barang -->
            <div class="space-y-2 text-center">
                <h3 class="text-2xl font-bold text-gray-800">{{ $item['name'] }}</h3>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($item['price'], 2, ',', '.') }}</p>
            </div>

            <!-- Jumlah Barang -->
            <div class="text-center">
                <label for="quantity" class="block text-lg font-semibold text-gray-800 mb-2">Jumlah</label>
                <div class="flex items-center justify-center space-x-4 mt-2">
                    <button type="button" id="decreaseQty" 
                            class="w-12 h-12 bg-gray-500 text-white rounded-full flex justify-center items-center text-2xl font-bold hover:bg-gray-600 transition">
                        <i class="fas fa-minus"></i>
                    </button>

                    <input type="number" name="quantity" id="quantity" 
                        class="w-24 text-center p-3 text-lg font-semibold border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        value="{{ $item['quantity'] }}" min="1" max="{{ $item['max_quantity'] ?? 100 }}" readonly>

                    <button type="button" id="increaseQty" 
                            class="w-12 h-12 bg-gray-500 text-white rounded-full flex justify-center items-center text-2xl font-bold hover:bg-gray-600 transition">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                @error('quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Tambahan -->
            <div>
                <label for="description" class="block text-lg font-medium text-gray-800">Deskripsi Tambahan</label>
                <textarea name="description" id="description" rows="3" 
                          class="w-full mt-2 p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" 
                          placeholder="Contoh: Warna merah, ukuran XL, bahan katun, dll.">{{ old('description', $item['description'] ?? '') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition text-lg">
                Simpan Perubahan
            </button>
        </form>

        <!-- Tombol Kembali -->
        <div class="text-center mt-6">
            <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-lg">
                Kembali ke Keranjang
            </a>
        </div>
    </div>
</div>

<!-- Script untuk Tombol -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const qtyInput = document.getElementById("quantity");
        const decreaseBtn = document.getElementById("decreaseQty");
        const increaseBtn = document.getElementById("increaseQty");
        const maxQty = parseInt(qtyInput.getAttribute("max"));

        decreaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue < maxQty) {
                qtyInput.value = currentValue + 1;
            }
        });
    });
</script>
@endsection