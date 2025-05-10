@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Inventori Dashboard</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-blue-100 text-blue-800 p-6 rounded-lg shadow-sm">
                <h2 class="text-sm font-medium uppercase">Total Barang</h2>
                <p class="text-3xl font-bold mt-2">{{ $items->count() }}</p>
            </div>
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow-sm">
                <h2 class="text-sm font-medium uppercase">Stok Rendah</h2>
                <p class="text-3xl font-bold mt-2">{{ $lowStockItems->count() }}</p>
            </div>
            <div class="bg-red-100 text-red-800 p-6 rounded-lg shadow-sm">
                <h2 class="text-sm font-medium uppercase">Obat Kedaluwarsa</h2>
                <p class="text-3xl font-bold mt-2">{{ $expiredMedicine->count() }}</p>
            </div>
            <div class="bg-green-100 text-green-800 p-6 rounded-lg shadow-sm">
                <h2 class="text-sm font-medium uppercase">Nilai Inventori</h2>
                <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Section Table -->
        <div class="space-y-12">

            <!-- Tabel Barang Stok Rendah -->
            <section>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Barang dengan Stok Rendah</h2>
                @forelse ($lowStockItems as $item)
                    <div class="overflow-x-auto rounded border">
                        <table class="min-w-full table-auto border-collapse bg-white">
                            <thead class="bg-gray-100 text-gray-700 text-sm sticky top-0">
                                <tr>
                                    <th class="p-3 text-left">Nama</th>
                                    <th class="p-3 text-left">Stok</th>
                                    <th class="p-3 text-left">Jenis</th>
                                    <th class="p-3 text-left">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockItems as $item)
                                    <tr class="border-t even:bg-yellow-50">
                                        <td class="p-3">{{ $item->name }}</td>
                                        <td class="p-3">{{ $item->quantity }}</td>
                                        <td class="p-3">{{ ucfirst($item->item_type) }}</td>
                                        <td class="p-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada barang dengan stok rendah.</p>
                @endforelse
            </section>

            <!-- Obat Stok Rendah -->
            <section>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Obat dengan Stok Rendah</h2>
                @forelse ($lowMedicine as $medicine)
                    <div class="overflow-x-auto rounded border">
                        <table class="min-w-full table-auto border-collapse bg-white">
                            <thead class="bg-gray-100 text-gray-700 text-sm sticky top-0">
                                <tr>
                                    <th class="p-3 text-left">Nama</th>
                                    <th class="p-3 text-left">Stok</th>
                                    <th class="p-3 text-left">Kedaluwarsa</th>
                                    <th class="p-3 text-left">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowMedicine as $medicine)
                                    <tr class="border-t even:bg-yellow-50">
                                        <td class="p-3">{{ $medicine->name }}</td>
                                        <td class="p-3">{{ $medicine->quantity }}</td>
                                        <td class="p-3">
                                            {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d-m-Y') }}</td>
                                        <td class="p-3">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada obat dengan stok rendah.</p>
                @endforelse
            </section>

            <!-- Obat Kedaluwarsa -->
            <section>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Obat Kedaluwarsa</h2>
                @forelse ($expiredMedicine as $medicine)
                    <div class="overflow-x-auto rounded border">
                        <table class="min-w-full table-auto border-collapse bg-white">
                            <thead class="bg-gray-100 text-gray-700 text-sm sticky top-0">
                                <tr>
                                    <th class="p-3 text-left">Nama</th>
                                    <th class="p-3 text-left">Stok</th>
                                    <th class="p-3 text-left">Kedaluwarsa</th>
                                    <th class="p-3 text-left">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expiredMedicine as $medicine)
                                    <tr class="border-t even:bg-red-50">
                                        <td class="p-3">{{ $medicine->item->name }}</td>
                                        <td class="p-3">{{ $medicine->item->quantity }}</td>
                                        <td class="p-3">
                                            {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d-m-Y') }}</td>
                                        <td class="p-3">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada obat yang kedaluwarsa.</p>
                @endforelse
            </section>
        </div>
    </div>
@endsection
