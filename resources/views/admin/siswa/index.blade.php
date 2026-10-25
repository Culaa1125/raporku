@extends('layouts.app')
@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')
@section('sidebar-nav') @include('layouts.partials.sidebar-admin') @endsection

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 w-full sm:w-auto">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NIS, kelas..."
            class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <div class="h-10 bg-blue-900 rounded-lg cursor-pointer select-none
            hover:translate-y-1 hover:[box-shadow:0_2px_0_0_#0f2a4a,0_3px_0_0_#0f2a4a41] hover:border-b-0
            active:translate-y-2 active:[box-shadow:0_0px_0_0_#0f2a4a,0_0px_0_0_#0f2a4a41] active:border-b-0
            transition-all duration-150 [box-shadow:0_4px_0_0_#0f2a4a,0_6px_0_0_#0f2a4a41]
            border-b border-blue-950 inline-flex">
            <button type="submit" class="flex items-center px-4 h-full text-sm text-white font-medium whitespace-nowrap">
                Cari
            </button>
        </div>

        @if($search)
        <div class="h-10 bg-white rounded-lg cursor-pointer select-none
            hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#d1d5db,0_3px_0_0_#d1d5db80] hover:border-b-0
            active:translate-y-1 active:[box-shadow:0_0px_0_0_#d1d5db,0_0px_0_0_#d1d5db80] active:border-b-0
            transition-all duration-150 [box-shadow:0_4px_0_0_#d1d5db,0_6px_0_0_#d1d5db80]
            border-b border-gray-300 inline-flex">
            <a href="{{ route('admin.siswa') }}"
            class="flex items-center px-4 h-full text-sm text-gray-500 font-medium whitespace-nowrap">
                Reset
            </a>
        </div>
        @endif
    </form>
    <div class="h-10 bg-blue-900 rounded-lg cursor-pointer select-none
        hover:translate-y-1 hover:[box-shadow:0_2px_0_0_#0f2a4a,0_3px_0_0_#0f2a4a41] hover:border-b-0
        active:translate-y-2 active:[box-shadow:0_0px_0_0_#0f2a4a,0_0px_0_0_#0f2a4a41] active:border-b-0
        transition-all duration-150 [box-shadow:0_4px_0_0_#0f2a4a,0_6px_0_0_#0f2a4a41]
        border-b border-blue-950 inline-flex">
        <a href="{{ route('admin.siswa.create') }}"
        class="flex items-center gap-2 px-4 h-full text-white text-sm font-medium whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Siswa
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold w-8">#</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">NIS</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Nama Siswa</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Kelas</th>
                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Email</th>
                <th class="px-4 py-3 text-center text-gray-600 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($siswa as $i => $s)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-400">{{ $siswa->firstItem() + $i }}</td>
                <td class="px-4 py-3 font-mono text-gray-700">{{ $s->nis }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $s->nama_siswa }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">{{ $s->kelas }}</span>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $s->user->email }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.siswa.edit', $s->id_siswa) }}"
                           class="px-3 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg text-xs font-medium transition">Edit</a>
                        <form method="POST" action="{{ route('admin.siswa.destroy', $s->id_siswa) }}"
                              onsubmit="return confirm('Hapus siswa {{ $s->nama_siswa }}?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">Tidak ada data siswa ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($siswa->hasPages())
    <div class="px-4 py-3 border-t">{{ $siswa->links() }}</div>
    @endif
</div>
@endsection