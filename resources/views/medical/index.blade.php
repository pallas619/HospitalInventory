@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Alat Medis</h2>
            <a href="{{ route('medical.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Tambah Alat
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">no</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Alat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal
                            Perawatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($equipments as $equipment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $equipment->item->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $equipment->department }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $equipment->operational_status == 'Aktif'
                                ? 'bg-green-100 text-green-800'
                                : ($equipment->operational_status == 'Rusak'
                                    ? 'bg-red-100 text-red-800'
                                    : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $equipment->operational_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($equipment->maintenance_schedule)
                                    <span
                                        class="{{ \Carbon\Carbon::parse($equipment->maintenance_schedule)->isPast() ? 'text-red-600' : 'text-blue-600' }}">
                                        {{ \Carbon\Carbon::parse($equipment->maintenance_schedule)->translatedFormat('d F Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('medical.edit', $equipment) }}"
                                        class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('medical.destroy', $equipment) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <p class="text-lg font-medium">Tidak ada data alat medis</p>
                                    <p class="text-sm mt-1">Silakan tambahkan alat medis baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($equipments) && method_exists($equipments, 'links') && $equipments->hasPages())
            <div class="mt-4">
                {{ $equipments->links() }}
            </div>
        @endif
    </div>
@endsection
