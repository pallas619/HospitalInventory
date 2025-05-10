@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Obat</h2>
            <a href="{{ route('medicines.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p class="font-bold">Terjadi kesalahan:</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('medicines.update', $medicine) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Nama Obat -->
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium text-gray-700">Nama Obat <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $medicine->item->name) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Dosis -->
                    <div class="space-y-2">
                        <label for="dosage" class="text-sm font-medium text-gray-700">Dosis <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="dosage" name="dosage" value="{{ old('dosage', $medicine->dosage) }}"
                            placeholder="Contoh: 500mg, 5ml"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Kuantitas -->
                    <div class="space-y-2">
                        <label for="quantity" class="text-sm font-medium text-gray-700">Kuantitas <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="quantity" name="quantity"
                            value="{{ old('quantity', $medicine->item->quantity) }}" min="0"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Harga -->
                    <div class="space-y-2">
                        <label for="price" class="text-sm font-medium text-gray-700">Harga (Rp) <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="price" name="price"
                            value="{{ old('price', $medicine->item->price) }}" min="0"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Tanggal Kadaluarsa -->
                    <div class="space-y-2">
                        <label for="expiry_date" class="text-sm font-medium text-gray-700">Tanggal Kadaluarsa <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="expiry_date" name="expiry_date"
                            value="{{ old('expiry_date', \Carbon\Carbon::parse($medicine->expiry_date)->format('Y-m-d')) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Perlu Resep -->
                    <div class="space-y-2">
                        <label for="requires_prescription" class="text-sm font-medium text-gray-700">Perlu Resep?</label>
                        <select id="requires_prescription" name="requires_prescription"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="0"
                                {{ old('requires_prescription', $medicine->requires_prescription ? '1' : '0') == '0' ? 'selected' : '' }}>
                                Tidak</option>
                            <option value="1"
                                {{ old('requires_prescription', $medicine->requires_prescription ? '1' : '0') == '1' ? 'selected' : '' }}>
                                Ya</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('medicines.index') }}"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition-colors text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors text-sm font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
