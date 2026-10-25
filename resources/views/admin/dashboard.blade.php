@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('sidebar-nav')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
{{-- Welcome Banner --}}
<div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl p-6 mb-6 text-white flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold mb-1">Selamat Datang, Admin! 👋</h2>
        <p class="text-blue-200 text-sm">Kelola data akademik SMA Lorem Ipsum dengan mudah.</p>
    </div>
    <div class="hidden md:block text-6xl opacity-20 font-black">A</div>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800">{{ $total_guru }}</div>
            <div class="text-sm text-gray-500">Banyak Guru</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800">{{ $total_siswa }}</div>
            <div class="text-sm text-gray-500">Banyak Siswa</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800">{{ $total_kelas }}</div>
            <div class="text-sm text-gray-500">Banyak Kelas</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800">{{ $total_mapel }}</div>
            <div class="text-sm text-gray-500">Mata Pelajaran</div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Jumlah Siswa per Kelas</h3>
        <canvas id="chartKelas" height="220"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Status Kelulusan Siswa</h3>
        <canvas id="chartKelulusan" height="220"></canvas>
    </div>
</div>

{{-- Quick Links --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
    <a href="{{ route('admin.siswa.create') }}" class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-3 hover:shadow-md transition group">
        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <div>
            <div class="font-semibold text-sm text-gray-800">Tambah Siswa</div>
            <div class="text-xs text-gray-500">Daftarkan siswa baru</div>
        </div>
    </a>
    <a href="{{ route('admin.guru.create') }}" class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-3 hover:shadow-md transition group">
        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <div>
            <div class="font-semibold text-sm text-gray-800">Tambah Guru</div>
            <div class="text-xs text-gray-500">Daftarkan guru baru</div>
        </div>
    </a>
    <a href="{{ route('admin.erapor') }}" class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-3 hover:shadow-md transition group">
        <div class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center group-hover:bg-yellow-600 group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
        <div>
            <div class="font-semibold text-sm text-gray-800">Input Nilai</div>
            <div class="text-xs text-gray-500">Masukkan nilai siswa</div>
        </div>
    </a>
</div>
@endsection

@push('scripts')
<script>
    // Chart Kelas
    const kelasData = @json($chart_kelas);
    new Chart(document.getElementById('chartKelas'), {
        type: 'bar',
        data: {
            labels: kelasData.map(d => d.kelas),
            datasets: [{
                label: 'Jumlah Siswa',
                data: kelasData.map(d => d.total),
                backgroundColor: '#3b82f6',
                borderRadius: 6,
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, aspectRatio: 2.5,plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    // Chart Kelulusan
    const kelulusanData = @json($chart_nilai);
    const lulus    = kelulusanData.find(d => d.status === 'Lulus')?.total || 0;
    const tidakLulus = kelulusanData.find(d => d.status === 'Tidak Lulus')?.total || 0;
    new Chart(document.getElementById('chartKelulusan'), {
        type: 'doughnut',
        data: {
            labels: ['Lulus', 'Tidak Lulus'],
            datasets: [{ data: [lulus, tidakLulus], backgroundColor: ['#22c55e', '#ef4444'], borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: true, aspectRatio: 2,plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endpush