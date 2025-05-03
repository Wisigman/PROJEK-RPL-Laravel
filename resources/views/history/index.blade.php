@extends('layouts.app')

@section('title', 'Purchase History')

@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Purchase History</h2>

    @if ($purchases->isEmpty())
        <p class="text-gray-600">You have not made any purchases yet.</p>
    @else
        <table class="min-w-full table-auto border-collapse shadow-lg rounded-lg overflow-hidden bg-white">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 border-b text-left">Order ID</th>
                    <th class="px-4 py-2 border-b text-left">Date</th>
                    <th class="px-4 py-2 border-b text-left">Product Name</th>
                    <th class="px-4 py-2 border-b text-left">Price</th>
                    <th class="px-4 py-2 border-b text-left">Total Amount</th>
                    <th class="px-4 py-2 border-b text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $purchase->id }}</td>
                        <td class="px-4 py-2 border-b">{{ $purchase->created_at->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 border-b">{{ $purchase->product_name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">Rp. {{ number_format($purchase->price, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border-b">Rp. {{ number_format($purchase->total_amount, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border-b">{{ ucfirst($purchase->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
