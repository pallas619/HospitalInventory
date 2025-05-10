@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Obat</h2>
            <a href="{{ route('medicines.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Tambah Obat
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Item
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kadaluarsa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perlu
                            Resep</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($medicines as $medicine)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $medicine->item->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $medicine->dosage }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="{{ \Carbon\Carbon::parse($medicine->expiry_date)->isPast() ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                                    {{ \Carbon\Carbon::parse($medicine->expiry_date)->translatedFormat('d F Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $medicine->requires_prescription ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $medicine->requires_prescription ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('medicines.edit', $medicine) }}"
                                        class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('medicines.destroy', $medicine) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Yakin ingin menghapus obat ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data obat tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($medicines->hasPages())
            <div class="mt-4">
                {{ $medicines->links() }}
            </div>
        @endif
    </div>
@endsection
