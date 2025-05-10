@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Pengguna</h2>
            <a href="{{ route('users.index') }}"
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
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium text-gray-700">Nama <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-gray-700">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2 md:col-span-2">
                        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <label for="role" class="text-sm font-medium text-gray-700">Role <span
                                class="text-red-500">*</span></label>
                        <select id="role" name="role"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                            <option value="" disabled>-- Pilih Role --</option>
                            <option value="Pharmacist" {{ $user->role == 'Pharmacist' ? 'selected' : '' }}> Pharmacist
                            </option>
                            <option value="Technician" {{ $user->role == 'Technician' ? 'selected' : '' }}>Technician
                            </option>
                            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="text-sm font-medium text-gray-700">Status <span
                                class="text-red-500">*</span></label>
                        <select id="status" name="status"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('users.index') }}"
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
