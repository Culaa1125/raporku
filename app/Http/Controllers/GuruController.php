<?php

namespace App\Http\Controllers;

use App\Models\{Guru, Siswa, Mapel, Nilai};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    private function getGuru()
    {
        return Guru::with('mapel')->where('id_user', Auth::id())->firstOrFail();
    }

    public function dashboard()
    {
        $guru       = $this->getGuru();
        $totalKelas = Siswa::distinct('kelas')->count('kelas');
        $totalSiswa = Siswa::count();
        $mapelSaya  = $guru->mapel->nama_mapel ?? '-';

        $nilaiStats = Nilai::where('id_guru', $guru->id_guru)
                          ->selectRaw('status, count(*) as total')
                          ->groupBy('status')->pluck('total', 'status');

        return view('guru.dashboard', compact('guru', 'totalKelas', 'totalSiswa', 'mapelSaya', 'nilaiStats'));
    }

    public function eRapor(Request $request)
    {
        $guru  = $this->getGuru();
        $siswa = Siswa::orderBy('kelas')->orderBy('nama_siswa')->get();
        $kelas = Siswa::distinct()->orderBy('kelas')->pluck('kelas');

        $nilai = Nilai::with(['siswa', 'mapel'])
                      ->where('id_guru', $guru->id_guru)
                      ->when($request->kelas, fn($q) => $q->where('kelas', $request->kelas))
                      ->orderBy('kelas')
                      ->paginate(20)->withQueryString();

        return view('guru.erapor', compact('guru', 'siswa', 'kelas', 'nilai'));
    }

    public function storeNilai(Request $request)
    {
        $guru = $this->getGuru();

        $request->validate([
            'id_siswa'     => 'required|exists:siswa,id_siswa',
            'kelas'        => 'required|string|max:10',
            'nilai_tugas'  => 'required|numeric|min:0|max:100',
            'nilai_uts'    => 'required|numeric|min:0|max:100',
            'nilai_uas'    => 'required|numeric|min:0|max:100',
            'tahun_ajaran' => 'required|string|max:25',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        $nilaiAkhir = Nilai::hitungNilaiAkhir($request->nilai_tugas, $request->nilai_uts, $request->nilai_uas);
        $status     = Nilai::tentukanStatus($nilaiAkhir);

        $existing = Nilai::where([
            'id_siswa'     => $request->id_siswa,
            'id_mapel'     => $guru->id_mapel,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
        ])->first();

        if ($existing) {
            $existing->update([
                'id_guru'      => $guru->id_guru,
                'kelas'        => $request->kelas,
                'nilai_tugas'  => $request->nilai_tugas,
                'nilai_uts'    => $request->nilai_uts,
                'nilai_uas'    => $request->nilai_uas,
                'nilai_akhir'  => $nilaiAkhir,
                'status'       => $status,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester'     => $request->semester,
            ]);
        } else {
            Nilai::create([
                'id_siswa'     => $request->id_siswa,
                'id_guru'      => $guru->id_guru,
                'id_mapel'     => $guru->id_mapel,
                'kelas'        => $request->kelas,
                'nilai_tugas'  => $request->nilai_tugas,
                'nilai_uts'    => $request->nilai_uts,
                'nilai_uas'    => $request->nilai_uas,
                'nilai_akhir'  => $nilaiAkhir,
                'status'       => $status,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester'     => $request->semester,
            ]);
        }

        return redirect()->route('guru.erapor')->with('success', 'Nilai berhasil disimpan.');
    }

    public function rekapNilai(Request $request)
    {
        $guru  = $this->getGuru();
        $kelas = Siswa::distinct()->orderBy('kelas')->pluck('kelas');

        $nilai = Nilai::with(['siswa', 'mapel'])
                      ->where('id_guru', $guru->id_guru)
                      ->when($request->kelas,    fn($q) => $q->where('kelas', $request->kelas))
                      ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
                      ->orderBy('kelas')->orderBy('id_siswa')
                      ->paginate(20)->withQueryString();

        return view('guru.rekapnilai', compact('guru', 'kelas', 'nilai'));
    }

    public function siswaByKelas(Request $request)
    {
        $siswa = Siswa::where('kelas', $request->kelas)
                    ->orderBy('nama_siswa')
                    ->get(['id_siswa', 'nama_siswa', 'nis', 'kelas']);

        return response()->json($siswa);
    }
}