@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard')
@section('sidebar-nav') @include('layouts.partials.sidebar-guru') @endsection

@section('content')
<div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl p-6 mb-6 text-white flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold mb-1">Selamat Datang, {{ $guru->nama_guru }}! 👋</h2>
        <p class="text-blue-200 text-sm">Mata Pelajaran: <span class="font-semibold text-white">{{ $mapelSaya }}</span></p>
    </div>
    <div class="hidden md:block text-6xl opacity-20 font-black">G</div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalKelas }}</div>
            <div class="text-sm text-gray-500">Total Kelas</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</div>
            <div class="text-sm text-gray-500">Jumlah Siswa</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
        </div>
        <div>
            <div class="text-lg font-bold text-gray-800">{{ $mapelSaya }}</div>
            <div class="text-sm text-gray-500">Mapel Saya</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Status Kelulusan Nilai yang Saya Input</h3>
        <div class="flex items-center justify-center">
            <canvas id="chartKelulusan" style="max-height: 220px;"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col justify-start">
        <h3 class="font-semibold text-gray-700 mb-4">Akses Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('guru.erapor') }}" class="flex items-center gap-3 p-4 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50 transition group">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-sm text-gray-800">Input Nilai Siswa</div>
                    <div class="text-xs text-gray-500">Masukkan nilai tugas, UTS, dan UAS</div>
                </div>
                <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('guru.rekap') }}" class="flex items-center gap-3 p-4 border border-gray-100 rounded-xl hover:border-green-200 hover:bg-green-50 transition group">
                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-sm text-gray-800">Lihat Rekap Nilai</div>
                    <div class="text-xs text-gray-500">Rekap nilai per kelas dan semester</div>
                </div>
                <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const lulus     = {{ $nilaiStats['Lulus'] ?? 0 }};
const tidakLulus = {{ $nilaiStats['Tidak Lulus'] ?? 0 }};
new Chart(document.getElementById('chartKelulusan'), {
    type: 'doughnut',
    data: {
        labels: ['Lulus', 'Tidak Lulus'],
        datasets: [{ data: [lulus, tidakLulus], backgroundColor: ['#22c55e','#ef4444'], borderWidth: 0 }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush