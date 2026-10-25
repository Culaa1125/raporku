@extends('layouts.app')
@section('title', 'Tambah Guru')
@section('page-title', 'Tambah Guru')
@section('sidebar-nav') @include('layouts.partials.sidebar-admin') @endsection

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.guru') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Data Guru
    </a>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Form Tambah Guru</h2>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5">
                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.guru.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIP <span class="text-red-500">*</span></label>
                <input type="text" name="nip" value="{{ old('nip') }}" required maxlength="20"
                       placeholder="Contoh: 198001012005011001"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nip') border-red-400 @enderror">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Guru <span class="text-red-500">*</span></label>
                <input type="text" name="nama_guru" value="{{ old('nama_guru') }}" required maxlength="50"
                       placeholder="Nama lengkap guru"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_guru') border-red-400 @enderror">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran yang Diampu <span class="text-red-500">*</span></label>
                <select name="id_mapel" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_mapel') border-red-400 @enderror">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapel as $m)
                        <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>
                            {{ $m->nama_mapel }} ({{ $m->kode_mapel }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="border-t pt-4 mt-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Akun Login</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="email@contoh.com"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="6"
                               placeholder="Min. 6 karakter"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-400 @enderror">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <div class="h-10 bg-gray-100 rounded-lg cursor-pointer select-none
                    hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#9ca3af,0_3px_0_0_#9ca3af80] hover:border-b-0
                    active:translate-y-1 active:[box-shadow:0_0px_0_0_#9ca3af,0_0px_0_0_#9ca3af80] active:border-b-0
                    transition-all duration-150 [box-shadow:0_4px_0_0_#9ca3af,0_6px_0_0_#9ca3af80]
                    border-b border-gray-400 inline-flex">
                    <a href="{{ route('admin.guru') }}"
                    class="flex items-center px-5 h-full text-sm text-gray-700 font-medium whitespace-nowrap">
                        Batal
                    </a>
                </div>

                <div class="h-10 bg-blue-900 rounded-lg cursor-pointer select-none
                    hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#0f2a4a,0_3px_0_0_#0f2a4a41] hover:border-b-0
                    active:translate-y-1 active:[box-shadow:0_0px_0_0_#0f2a4a,0_0px_0_0_#0f2a4a41] active:border-b-0
                    transition-all duration-150 [box-shadow:0_4px_0_0_#0f2a4a,0_6px_0_0_#0f2a4a41]
                    border-b border-blue-950 inline-flex">
                    <button type="submit"
                            class="flex items-center px-5 h-full text-white text-sm font-medium whitespace-nowrap">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection