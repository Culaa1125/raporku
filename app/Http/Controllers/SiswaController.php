<?php

namespace App\Http\Controllers;

use App\Models\{Siswa, Nilai};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    private function getSiswa()
    {
        return Siswa::where('id_user', Auth::id())->firstOrFail();
    }

    public function dashboard()
    {
        $siswa      = $this->getSiswa();
        $totalMapel = Nilai::where('id_siswa', $siswa->id_siswa)
                           ->distinct('id_mapel')
                           ->count('id_mapel');
        $rataRata   = Nilai::where('id_siswa', $siswa->id_siswa)
                           ->avg('nilai_akhir') ?? 0;
        $totalLulus = Nilai::where('id_siswa', $siswa->id_siswa)
                           ->where('status', 'Lulus')
                           ->count();
        $chartNilai = Nilai::with('mapel')
                           ->where('id_siswa', $siswa->id_siswa)
                           ->orderBy('id_mapel')
                           ->get();

        return view('siswa.dashboard', compact(
            'siswa', 'totalMapel', 'rataRata', 'totalLulus', 'chartNilai'
        ));
    }

    public function nilai(Request $request)
    {
        $siswa = $this->getSiswa();

        $nilai = Nilai::with(['mapel', 'guru'])
                      ->where('id_siswa', $siswa->id_siswa)
                      ->when($request->semester,     fn($q) => $q->where('semester', $request->semester))
                      ->when($request->tahun_ajaran, fn($q) => $q->where('tahun_ajaran', $request->tahun_ajaran))
                      ->orderBy('tahun_ajaran', 'desc')
                      ->orderBy('semester')
                      ->get();

        $tahunList = Nilai::where('id_siswa', $siswa->id_siswa)
                          ->distinct()
                          ->orderByDesc('tahun_ajaran')
                          ->pluck('tahun_ajaran');

        return view('siswa.nilai', compact('siswa', 'nilai', 'tahunList'));
    }

    public function statusKelulusan(Request $request)
    {
        $siswa = $this->getSiswa();

        $nilai = Nilai::with('mapel')
                      ->where('id_siswa', $siswa->id_siswa)
                      ->when($request->tahun_ajaran, fn($q) => $q->where('tahun_ajaran', $request->tahun_ajaran))
                      ->when($request->semester,     fn($q) => $q->where('semester', $request->semester))
                      ->when($request->status,       fn($q) => $q->where('status', $request->status))
                      ->orderBy('tahun_ajaran', 'desc')
                      ->orderBy('semester')
                      ->get();

        $tahunList = Nilai::where('id_siswa', $siswa->id_siswa)
                          ->distinct()
                          ->orderByDesc('tahun_ajaran')
                          ->pluck('tahun_ajaran');

        $totalLulus      = $nilai->where('status', 'Lulus')->count();
        $totalTidakLulus = $nilai->where('status', 'Tidak Lulus')->count();

        return view('siswa.kelulusan', compact(
            'siswa', 'nilai', 'tahunList', 'totalLulus', 'totalTidakLulus'
        ));
    }
}