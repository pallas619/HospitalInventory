@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Alat Medis</h2>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <form action="{{ route('medical.update', $equipment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Alat</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $equipment->item->name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" id="quantity" name="quantity"
                        value="{{ old('quantity', $equipment->item->quantity) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="text" id="price" name="price"
                            value="{{ old('price', $equipment->item->price) }}"
                            class="block w-full pl-12 pr-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                    <input type="text" id="department" name="department"
                        value="{{ old('department', $equipment->department) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('department')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Operasional</label>
                    <select id="operational_status" name="operational_status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="Active" {{ $equipment->operational_status == 'Active' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="Maintenance"
                            {{ $equipment->operational_status == 'Maintenance' ? 'selected' : '' }}>
                            Perawatan</option>
                        <option value="Broken" {{ $equipment->operational_status == 'Broken' ? 'selected' : '' }}>Rusak
                        </option>
                    </select>
                    @error('operational_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="maintenance_schedule" class="block text-sm font-medium text-gray-700 mb-1">Jadwal
                        Perawatan</label>
                    <input type="date" id="maintenance_schedule" name="maintenance_schedule"
                        value="{{ old('maintenance_schedule', $equipment->maintenance_schedule ? \Carbon\Carbon::parse($equipment->maintenance_schedule)->format('Y-m-d') : '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('maintenance_schedule')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('medical.index') }}" class="mr-3 text-gray-500 hover:text-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
