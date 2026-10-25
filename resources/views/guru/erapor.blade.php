@extends('layouts.app')
@section('title', 'E-Rapor')
@section('page-title', 'E-Rapor - Input Nilai')
@section('sidebar-nav') @include('layouts.partials.sidebar-guru') @endsection

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Form --}}
    <div class="xl:col-span-1">
        <div class="bg-white rounded-xl shadow-sm p-6" x-data="nilaiForm()">
            <h3 class="font-semibold text-gray-800 mb-1">Input Nilai Siswa</h3>
            <p class="text-xs text-gray-400 mb-5">Mata Pelajaran: <span class="font-semibold text-blue-700">{{ $guru->mapel->nama_mapel ?? '-' }}</span></p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                    <ul class="list-disc list-inside text-red-700 text-xs space-y-1">
                        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('guru.nilai.store') }}" class="space-y-4">
                @csrf

                {{-- Pilih Kelas --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas" required x-model="kelasSelected" @change="loadSiswa()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k }}" {{ old('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Siswa (dinamis berdasarkan kelas) --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Siswa <span class="text-red-500">*</span></label>
                    <select name="id_siswa" required
                            :disabled="siswaList.length === 0"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-50 disabled:text-gray-400">
                        <option value="">-- Pilih Siswa --</option>
                        <template x-for="s in siswaList" :key="s.id_siswa">
                            <option :value="s.id_siswa"
                                    :selected="s.id_siswa == {{ old('id_siswa', 0) }}"
                                    x-text="s.nama_siswa + ' — NIS: ' + s.nis">
                            </option>
                        </template>
                    </select>
                    <p x-show="!kelasSelected" class="text-xs text-gray-400 mt-1">Pilih kelas terlebih dahulu.</p>
                    <p x-show="kelasSelected && siswaList.length === 0 && !loadingSiswa" class="text-xs text-red-400 mt-1">Tidak ada siswa di kelas ini.</p>
                    <p x-show="loadingSiswa" class="text-xs text-blue-400 mt-1">Memuat data siswa...</p>
                </div>

                {{-- Semester & Tahun Ajaran --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Semester <span class="text-red-500">*</span></label>
                        <select name="semester" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Semester --</option>
                            <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap"  {{ old('semester') == 'Genap'  ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                        <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', '2025/2026') }}" required
                               placeholder="2025/2026"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Input Nilai --}}
                <div class="border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Nilai (0–100)</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <label class="text-xs text-gray-600 w-16 flex-shrink-0">Tugas (30%)</label>
                            <input type="number" name="nilai_tugas" x-model="tugas" @input="hitung()"
                                   value="{{ old('nilai_tugas') }}" min="0" max="100" step="0.01" required
                                   class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="text-xs text-gray-600 w-16 flex-shrink-0">UTS (30%)</label>
                            <input type="number" name="nilai_uts" x-model="uts" @input="hitung()"
                                   value="{{ old('nilai_uts') }}" min="0" max="100" step="0.01" required
                                   class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="text-xs text-gray-600 w-16 flex-shrink-0">UAS (40%)</label>
                            <input type="number" name="nilai_uas" x-model="uas" @input="hitung()"
                                   value="{{ old('nilai_uas') }}" min="0" max="100" step="0.01" required
                                   class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Preview Nilai Akhir --}}
                <div class="rounded-xl p-4 text-center transition-all"
                    :class="{
                        'bg-gray-50'                          : nilaiAkhir === null && !errorNilai,
                        'bg-green-50 border border-green-200' : nilaiAkhir !== null && nilaiAkhir >= 70,
                        'bg-red-50 border border-red-200'     : (nilaiAkhir !== null && nilaiAkhir < 70) || errorNilai
                    }">

                    {{-- Ikon & Angka --}}
                    <div class="text-3xl font-bold"
                        :class="{
                            'text-gray-300'  : nilaiAkhir === null && !errorNilai,
                            'text-green-600' : nilaiAkhir !== null && nilaiAkhir >= 70,
                            'text-red-600'   : (nilaiAkhir !== null && nilaiAkhir < 70) || errorNilai
                        }">
                        <span x-show="!errorNilai" x-text="nilaiAkhir !== null ? nilaiAkhir.toFixed(2) : '-'"></span>
                        <span x-show="errorNilai">⚠</span>
                    </div>

                    {{-- Pesan Status --}}
                    <div class="text-xs font-semibold mt-1"
                        :class="{
                            'text-gray-400'  : nilaiAkhir === null && !errorNilai,
                            'text-green-500' : nilaiAkhir !== null && nilaiAkhir >= 70,
                            'text-red-500'   : (nilaiAkhir !== null && nilaiAkhir < 70) || errorNilai
                        }">
                        <span x-show="nilaiAkhir === null && !errorNilai">Isi semua nilai</span>
                        <span x-show="nilaiAkhir !== null && nilaiAkhir >= 70">✓ LULUS</span>
                        <span x-show="nilaiAkhir !== null && nilaiAkhir < 70 && !errorNilai">✗ TIDAK LULUS</span>
                        <span x-show="errorNilai" x-text="errorNilai"></span>
                    </div>

                    <div class="text-xs text-gray-400 mt-1">30% Tugas + 30% UTS + 40% UAS</div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="w-full bg-blue-900 rounded-lg cursor-pointer select-none
                    hover:translate-y-0.5 hover:[box-shadow:0_2px_0_0_#0f2a4a,0_3px_0_0_#0f2a4a41] hover:border-b-0
                    active:translate-y-1 active:[box-shadow:0_0px_0_0_#0f2a4a,0_0px_0_0_#0f2a4a41] active:border-b-0
                    transition-all duration-150 [box-shadow:0_4px_0_0_#0f2a4a,0_6px_0_0_#0f2a4a41]
                    border-b border-blue-950">
                    <button type="submit"
                            class="flex items-center justify-center w-full py-2.5 text-white text-sm font-medium">
                        Simpan Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="xl:col-span-2">
        <form method="GET" class="bg-white rounded-xl shadow-sm p-4 mb-4 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Filter Kelas</label>
                <select name="kelas" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
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
                <a href="{{ route('guru.erapor') }}"
                   class="flex items-center px-4 h-full text-sm text-gray-500 font-medium whitespace-nowrap">
                    Reset
                </a>
            </div>
        </form>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b flex items-center justify-between">
                <h3 class="font-semibold text-gray-700 text-sm">Nilai yang Telah Diinput</h3>
                <span class="text-xs text-gray-400">{{ $nilai->total() }} data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-3 py-3 text-left text-gray-600 font-semibold text-xs">Siswa</th>
                            <th class="px-3 py-3 text-left text-gray-600 font-semibold text-xs">Mapel</th>
                            <th class="px-3 py-3 text-center text-gray-600 font-semibold text-xs">Tugas</th>
                            <th class="px-3 py-3 text-center text-gray-600 font-semibold text-xs">UTS</th>
                            <th class="px-3 py-3 text-center text-gray-600 font-semibold text-xs">UAS</th>
                            <th class="px-3 py-3 text-center text-gray-600 font-semibold text-xs">Akhir</th>
                            <th class="px-3 py-3 text-center text-gray-600 font-semibold text-xs">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($nilai as $n)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 py-3">
                                <div class="font-medium text-gray-800 text-xs">{{ $n->siswa->nama_siswa ?? '-' }}</div>
                                <div class="text-gray-400 text-xs">{{ $n->kelas }} &bull; {{ $n->semester }}</div>
                            </td>
                            <td class="px-3 py-3 text-xs text-gray-600">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                            <td class="px-3 py-3 text-center text-xs">{{ $n->nilai_tugas }}</td>
                            <td class="px-3 py-3 text-center text-xs">{{ $n->nilai_uts }}</td>
                            <td class="px-3 py-3 text-center text-xs">{{ $n->nilai_uas }}</td>
                            <td class="px-3 py-3 text-center font-bold text-sm">{{ $n->nilai_akhir }}</td>
                            <td class="px-3 py-3 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $n->status === 'Lulus' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $n->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">Belum ada nilai yang diinput.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($nilai->hasPages())
            <div class="px-4 py-3 border-t">{{ $nilai->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function nilaiForm() {
    return {
        tugas: '{{ old('nilai_tugas', '') }}',
        uts:   '{{ old('nilai_uts', '') }}',
        uas:   '{{ old('nilai_uas', '') }}',
        nilaiAkhir: null,
        errorNilai: '',
        kelasSelected: '{{ old('kelas', '') }}',
        siswaList: [],
        loadingSiswa: false,

        init() {
            if (this.kelasSelected) {
                this.loadSiswa();
            }
        },

        loadSiswa() {
            this.siswaList = [];
            if (!this.kelasSelected) return;

            this.loadingSiswa = true;
            fetch(`/guru/api/siswa-by-kelas?kelas=${encodeURIComponent(this.kelasSelected)}`)
                .then(res => res.json())
                .then(data => {
                    this.siswaList = data;
                    this.loadingSiswa = false;
                })
                .catch(() => { this.loadingSiswa = false; });
        },

        hitung() {
            const t = parseFloat(this.tugas);
            const u = parseFloat(this.uts);
            const a = parseFloat(this.uas);

            // Cek apakah ada nilai yang keluar dari range
            this.errorNilai = '';
            if ((!isNaN(t) && (t < 0 || t > 100)) ||
                (!isNaN(u) && (u < 0 || u > 100)) ||
                (!isNaN(a) && (a < 0 || a > 100))) {
                this.errorNilai = 'Nilai tidak boleh kurang dari 0 atau lebih dari 100.';
                this.nilaiAkhir = null;
                return;
            }

            if (this.tugas !== '' && this.uts !== '' && this.uas !== '') {
                this.nilaiAkhir = (0.3 * t) + (0.3 * u) + (0.4 * a);
            } else {
                this.nilaiAkhir = null;
            }
        },
    }
}
</script>
@endpush