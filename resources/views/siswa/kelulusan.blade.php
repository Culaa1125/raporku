@extends('layouts.app')
@section('title', 'Status Kelulusan')
@section('page-title', 'Status Kelulusan')
@section('sidebar-nav') @include('layouts.partials.sidebar-siswa') @endsection

@section('content')

@php
    $totalMapel = $totalLulus + $totalTidakLulus;
    $pctLulus   = $totalMapel > 0 ? round($totalLulus / $totalMapel * 100) : 0;
    $semuaLulus = $totalTidakLulus === 0 && $totalMapel > 0;
@endphp

{{-- Banner --}}
<div class="rounded-2xl p-6 mb-6 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4
    {{ $semuaLulus ? 'bg-gradient-to-r from-green-600 to-emerald-500' : 'bg-gradient-to-r from-blue-900 to-blue-700' }}">
    <div>
        <h2 class="text-xl font-bold mb-1">
            {{ $semuaLulus ? '🎉 Semua Mata Pelajaran Lulus!' : '📋 Status Kelulusan Kamu' }}
        </h2>
        <p class="text-white/80 text-sm">
            Lulus <span class="font-bold text-white">{{ $totalLulus }}</span> dari
            <span class="font-bold text-white">{{ $totalMapel }}</span> mata pelajaran
            @if($totalTidakLulus > 0)
                &mdash; <span class="text-red-200 font-semibold">{{ $totalTidakLulus }} belum lulus</span>
            @endif
        </p>
    </div>
    {{-- Progress Ring --}}
    <div class="flex items-center gap-3 bg-white/10 rounded-xl px-5 py-3">
        <div class="relative w-14 h-14">
            @php $circumference = round(2 * M_PI * 22); @endphp
            <svg class="w-14 h-14 -rotate-90" viewBox="0 0 56 56">
                <circle cx="28" cy="28" r="22" stroke="white" stroke-opacity="0.2" stroke-width="5" fill="none"/>
                <circle cx="28" cy="28" r="22" stroke="white" stroke-width="5" fill="none"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ round($circumference * (1 - $pctLulus / 100)) }}"
                    stroke-linecap="round"/>
            </svg>
            <span class="absolute inset-0 flex items-center justify-center text-sm font-bold text-white">
                {{ $pctLulus }}%
            </span>
        </div>
        <div class="text-white/80 text-xs leading-relaxed">
            Tingkat<br><span class="text-white font-semibold text-sm">Kelulusan</span>
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    @include('layouts.partials.stat-card', [
        'title' => 'Total Mata Pelajaran',
        'value' => $totalMapel,
        'color' => 'blue',
        'icon'  => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'
    ])
    @include('layouts.partials.stat-card', [
        'title' => 'Lulus',
        'value' => $totalLulus,
        'color' => 'green',
        'icon'  => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>'
    ])
    @include('layouts.partials.stat-card', [
        'title' => 'Belum Lulus',
        'value' => $totalTidakLulus,
        'color' => $totalTidakLulus > 0 ? 'red' : 'green',
        'icon'  => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
    ])
</div>

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
    <div>
        <label class="block text-xs text-gray-500 mb-1">Status</label>
        <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua</option>
            <option value="Lulus"       {{ request('status') == 'Lulus'       ? 'selected' : '' }}>Lulus</option>
            <option value="Tidak Lulus" {{ request('status') == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
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
        <a href="{{ route('siswa.kelulusan') }}"
        class="flex items-center px-4 h-full text-sm text-gray-500 font-medium whitespace-nowrap">
            Reset
        </a>
    </div>
</form>
{{-- Tabel --}}
@if($nilai->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
    <svg class="w-12 h-12 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
    </svg>
        <p class="text-gray-400 text-sm">Belum ada data kelulusan.</p>
    </div>
@else
    @php
        $grouped = $nilai->groupBy(fn($n) => $n->tahun_ajaran . ' - Semester ' . $n->semester);
    @endphp

    @foreach($grouped as $label => $items)
    @php
        $lulus      = $items->where('status', 'Lulus')->count();
        $tidakLulus = $items->where('status', 'Tidak Lulus')->count();
    @endphp
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-5 py-3 bg-blue-900 text-white flex flex-wrap items-center justify-between gap-2">
            <h3 class="font-semibold text-sm">{{ $label }}</h3>
            <div class="flex items-center gap-2 text-xs">
                <span class="bg-green-500/20 text-green-200 px-2 py-0.5 rounded-full">✓ {{ $lulus }} Lulus</span>
                @if($tidakLulus > 0)
                    <span class="bg-red-500/20 text-red-200 px-2 py-0.5 rounded-full">✗ {{ $tidakLulus }} Tidak Lulus</span>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">#</th>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold text-xs">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Nilai Akhir</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">KKM</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Status</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold text-xs">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($items as $i => $n)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800 text-xs">
                            {{ $n->mapel->nama_mapel ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-bold text-base {{ $n->nilai_akhir >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($n->nilai_akhir, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-xs text-gray-400 font-mono">70.00</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $n->status === 'Lulus' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $n->status === 'Lulus' ? '✓ Lulus' : '✗ Tidak Lulus' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-xs">
                            @if($n->status === 'Lulus')
                                <span class="text-green-600">Memenuhi KKM</span>
                            @else
                                <span class="text-red-500">Di bawah KKM</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-xs text-gray-500 font-medium">Rata-rata Nilai Akhir</td>
                        <td class="px-4 py-3 text-center font-bold text-sm text-blue-700">
                            {{ number_format($items->avg('nilai_akhir'), 2) }}
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endforeach
@endif

@endsection