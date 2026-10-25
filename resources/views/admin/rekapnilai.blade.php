@extends('layouts.app')
@section('title', 'Rekap Nilai')
@section('page-title', 'Rekap Nilai')
@section('sidebar-nav') @include('layouts.partials.sidebar-admin') @endsection

@section('content')
{{-- Filter --}}
<form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Kelas</label>
        <select name="kelas" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
                <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Mata Pelajaran</label>
        <select name="id_mapel" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Mapel</option>
            @foreach($mapel as $m)
                <option value="{{ $m->id_mapel }}" {{ request('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Tahun Ajaran</label>
        <select name="tahun_ajaran" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Tahun</option>
            @foreach($tahunList as $t)
                <option value="{{ $t }}" {{ request('tahun_ajaran') == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Semester</label>
        <select name="semester" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua</option>
            <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
            <option value="Genap"  {{ request('semester') == 'Genap'  ? 'selected' : '' }}>Genap</option>
        </select>
    </div>
    <div class="h-10 bg-blue-900 rounded-lg cursor-pointer select-none
        hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#0f2a4a,0_3px_0_0_#0f2a4a41] hover:border-b-0
        active:translate-y-1 active:[box-shadow:0_0px_0_0_#0f2a4a,0_0px_0_0_#0f2a4a41] active:border-b-0
        transition-all duration-150 [box-shadow:0_4px_0_0_#0f2a4a,0_6px_0_0_#0f2a4a41]
        border-b border-blue-950 inline-flex">
        <button type="submit" class="flex items-center px-4 h-full text-sm text-white font-medium whitespace-nowrap">
            Filter
        </button>
    </div>
    <div class="h-10 bg-gray-100 rounded-lg cursor-pointer select-none
        hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#9ca3af,0_3px_0_0_#9ca3af80] hover:border-b-0
        active:translate-y-1 active:[box-shadow:0_0px_0_0_#9ca3af,0_0px_0_0_#9ca3af80] active:border-b-0
        transition-all duration-150 [box-shadow:0_4px_0_0_#9ca3af,0_6px_0_0_#9ca3af80]
        border-b border-gray-300 inline-flex">
        <a href="{{ route('admin.rekap') }}"
        class="flex items-center px-4 h-full text-sm text-gray-500 font-medium whitespace-nowrap">
            Reset
        </a>
    </div>
    <div class="h-10 bg-green-600 rounded-lg cursor-pointer select-none ml-auto
        hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#166534,0_3px_0_0_#16653441] hover:border-b-0
        active:translate-y-1 active:[box-shadow:0_0px_0_0_#166534,0_0px_0_0_#16653441] active:border-b-0
        transition-all duration-150 [box-shadow:0_4px_0_0_#166534,0_6px_0_0_#16653441]
        border-b border-green-800 inline-flex">
        <button type="button" onclick="window.print()"
                class="flex items-center gap-2 px-4 h-full text-sm text-white font-medium whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak
        </button>
    </div>
</form>

<div class="bg-white rounded-xl shadow-sm overflow-hidden" id="print-area">
    <div class="px-5 py-4 border-b flex items-center justify-between">
        <div>
            <h3 class="font-semibold text-gray-800">Rekap Nilai Siswa</h3>
            <p class="text-xs text-gray-400 mt-0.5">Total: {{ $nilai->total() }} data</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">#</th>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Nama Siswa</th>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Kelas</th>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Mata Pelajaran</th>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Tahun Ajaran</th>
                    <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Semester</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Tugas</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">UTS</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">UAS</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Nilai Akhir</th>
                    <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($nilai as $i => $n)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $nilai->firstItem() + $i }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800 text-xs">{{ $n->siswa->nama_siswa ?? '-' }}</td>
                    <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ $n->kelas }}</span>
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-600">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $n->tahun_ajaran }}</td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $n->semester }}</td>
                    <td class="px-4 py-3 text-center text-xs">{{ $n->nilai_tugas }}</td>
                    <td class="px-4 py-3 text-center text-xs">{{ $n->nilai_uts }}</td>
                    <td class="px-4 py-3 text-center text-xs">{{ $n->nilai_uas }}</td>
                    <td class="px-4 py-3 text-center font-bold text-sm">{{ $n->nilai_akhir }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $n->status === 'Lulus' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $n->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="11" class="px-4 py-10 text-center text-gray-400">Tidak ada data nilai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($nilai->hasPages())
    <div class="px-4 py-3 border-t">{{ $nilai->links() }}</div>
    @endif
</div>
@endsection