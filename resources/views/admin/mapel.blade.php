@extends('layouts.app')
@section('title', 'Mata Pelajaran')
@section('page-title', 'Mata Pelajaran')
@section('sidebar-nav') @include('layouts.partials.sidebar-admin') @endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Form Tambah --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-5">Tambah Mata Pelajaran</h3>
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                    <ul class="list-disc list-inside text-red-700 text-xs space-y-1">
                        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.mapel.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kode Mapel <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_mapel" value="{{ old('kode_mapel') }}" required maxlength="20"
                           placeholder="MTK, BIN, FIS..."
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}" required maxlength="50"
                           placeholder="Matematika, Fisika..."
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat mata pelajaran (opsional)"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="w-full bg-blue-900 rounded-lg cursor-pointer select-none
                    hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#0f2a4a,0_3px_0_0_#0f2a4a41] hover:border-b-0
                    active:translate-y-1 active:[box-shadow:0_0px_0_0_#0f2a4a,0_0px_0_0_#0f2a4a41] active:border-b-0
                    transition-all duration-150 [box-shadow:0_4px_0_0_#0f2a4a,0_6px_0_0_#0f2a4a41]
                    border-b border-blue-950">
                    <button type="submit" class="flex items-center justify-center w-full py-2.5 text-white text-sm font-medium">
                        Tambah Mata Pelajaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b">
                <h3 class="font-semibold text-gray-700 text-sm">Daftar Mata Pelajaran</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">#</th>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Kode</th>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Nama Mapel</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Guru</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($mapel as $i => $m)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded font-mono text-xs">{{ $m->kode_mapel }}</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800 text-xs">{{ $m->nama_mapel }}</td>
                        <td class="px-4 py-3 text-center text-xs text-gray-500">{{ $m->guru_count }} guru</td>
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('admin.mapel.destroy', $m->id_mapel) }}"
                                  onsubmit="return confirm('Hapus mata pelajaran {{ $m->nama_mapel }}? Pastikan tidak ada guru yang mengampu.')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400 text-sm">Belum ada mata pelajaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection