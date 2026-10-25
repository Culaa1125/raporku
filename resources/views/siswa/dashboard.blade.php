    @extends('layouts.app')
    @section('title', 'Dashboard Siswa')
    @section('page-title', 'Dashboard')
    @section('sidebar-nav') @include('layouts.partials.sidebar-siswa') @endsection

    @section('content')
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl p-6 mb-6 text-white flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold mb-1">Selamat Datang, {{ $siswa->nama_siswa }}! 👋</h2>
            <p class="text-blue-200 text-sm">Kelas: <span class="font-semibold text-white">{{ $siswa->kelas }}</span>
            &nbsp;&bull;&nbsp; NIS: <span class="font-semibold text-white">{{ $siswa->nis }}</span></p>
        </div>
        <div class="hidden md:block text-6xl opacity-20 font-black">S</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalMapel }}</div>
                <div class="text-sm text-gray-500">Total Mata Pelajaran</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ number_format($rataRata, 1) }}</div>
                <div class="text-sm text-gray-500">Rata-rata Nilai</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalLulus }}</div>
                <div class="text-sm text-gray-500">Mata Pelajaran Lulus</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Nilai per Mata Pelajaran</h3>
            @if($chartNilai->isEmpty())
                <div class="text-center py-10 text-gray-400 text-sm">Belum ada data nilai.</div>
            @else
                <canvas id="chartNilai" height="220"></canvas>
            @endif
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Akses Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('siswa.nilai') }}" class="flex items-center gap-3 p-4 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50 transition group">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-gray-800">Lihat Nilai Saya</div>
                        <div class="text-xs text-gray-500">Nilai tugas, UTS, UAS, dan nilai akhir</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('siswa.kelulusan') }}" class="flex items-center gap-3 p-4 border border-gray-100 rounded-xl hover:border-green-200 hover:bg-green-50 transition group">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-gray-800">Status Kelulusan</div>
                        <div class="text-xs text-gray-500">Cek status lulus/tidak lulus per mapel</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
    @if(!$chartNilai->isEmpty())
    const labels = @json($chartNilai->pluck('mapel.nama_mapel'));
    const data   = @json($chartNilai->pluck('nilai_akhir'));
    new Chart(document.getElementById('chartNilai'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Nilai Akhir',
                data,
                backgroundColor: data.map(v => v >= 70 ? '#22c55e' : '#ef4444'),
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100, ticks: { stepSize: 10 } } }
        }
    });
    @endif
    </script>
    @endpush