@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Tambah Consumable</h2>
    <form action="{{ route('consumables.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-600">Nama Alat</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Jumlah Alat</label>
            <input type="number" name="quantity" class="w-full border-gray-300 rounded px-3 py-2" min="0" required>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Harga Alat</label>
            <input type="number" name="price" class="w-full border-gray-300 rounded px-3 py-2" min="0" required>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Jenis Penggunaan</label>
            <select name="usage_type" class="w-full border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Single Use">Single Use</option>
                <option value="Multiple Use">Multiple Use</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Status Sterilisasi</label>
            <select name="sterilization_status" class="w-full border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Pilih Status --</option>
                <option value="Sterilized">Sterilized</option>
                <option value="Not Sterilized">Not Sterilized</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Tanggal Kadaluarsa</label>
            <input type="date" name="expiry_date" class="w-full border-gray-300 rounded px-3 py-2" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
@endsection
