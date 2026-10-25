@extends('layouts.app')
@section('title', 'Nilai Saya')
@section('page-title', 'Nilai Saya')
@section('sidebar-nav') @include('layouts.partials.sidebar-siswa') @endsection

@section('content')
{{-- Filter --}}
<form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Semester</label>
        <select name="semester" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua</option>
            <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
            <option value="Genap"  {{ request('semester') == 'Genap'  ? 'selected' : '' }}>Genap</option>
        </select>
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Tahun Ajaran</label>
        <select name="tahun_ajaran" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua</option>
            @foreach($tahunList as $t)
                <option value="{{ $t }}" {{ request('tahun_ajaran') == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
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
        <a href="{{ route('siswa.nilai') }}"
        class="flex items-center px-4 h-full text-sm text-gray-500 font-medium whitespace-nowrap">
            Reset
        </a>
    </div>
</form>

@if($nilai->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
        <svg class="w-12 h-12 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="text-gray-400 text-sm">Belum ada nilai yang tersedia.</p>
    </div>
@else
    @php
        $grouped = $nilai->groupBy(fn($n) => $n->tahun_ajaran . ' - Semester ' . $n->semester);
    @endphp

    @foreach($grouped as $label => $items)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-5 py-3 bg-blue-900 text-white flex items-center justify-between">
            <h3 class="font-semibold text-sm">{{ $label }}</h3>
            <span class="text-xs text-blue-200">{{ $items->count() }} mata pelajaran</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">#</th>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Guru</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Tugas (30%)</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">UTS (30%)</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">UAS (40%)</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Nilai Akhir</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($items as $i => $n)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800 text-xs">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $n->guru->nama_guru ?? '-' }}</td>
                        <td class="px-4 py-3 text-center text-xs">
                            <span class="font-mono">{{ number_format($n->nilai_tugas, 1) }}</span>
                        </td>
                        <td class="px-4 py-3 text-center text-xs">
                            <span class="font-mono">{{ number_format($n->nilai_uts, 1) }}</span>
                        </td>
                        <td class="px-4 py-3 text-center text-xs">
                            <span class="font-mono">{{ number_format($n->nilai_uas, 1) }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-bold text-base {{ $n->nilai_akhir >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($n->nilai_akhir, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $n->status === 'Lulus' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $n->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t">
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-xs text-gray-500 font-medium">Rata-rata Nilai Akhir</td>
                        <td class="px-4 py-3 text-center font-bold text-sm text-blue-700">
                            {{ number_format($items->avg('nilai_akhir'), 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endforeach
@endif
@endsection