<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .text-center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <h2 class="text-center">Bukti Pembayaran</h2>
    <p>Atas Nama: <strong>{{ $user->name }}</strong></p>
    <p>ID Pelanggan: <strong>{{ $user->id }}</strong></p>
    <p>ID Pesanan: <strong>{{ $order['id'] ?? 'N/A' }}</strong></p>
    <p>Detail Pesanan:</p>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>Rp. {{ number_format($item['price'], 2, ',', '.') }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rp. {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                    <td>{{ $item['description'] ?? 'Tidak ada deskripsi' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="text-center">Total: Rp. {{ number_format($totalHarga, 2, ',', '.') }}</h3>
</body>
</html>