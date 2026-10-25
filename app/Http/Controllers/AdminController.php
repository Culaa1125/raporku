<?php

namespace App\Http\Controllers;

use App\Models\{Guru, Siswa, Mapel, Nilai, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash};

class AdminController extends Controller
{
    // ─── Dashboard ─────────────────────────────────────────────
    public function dashboard()
    {
        $data = [
            'total_guru'   => Guru::count(),
            'total_siswa'  => Siswa::count(),
            'total_kelas'  => Siswa::distinct('kelas')->count('kelas'),
            'total_mapel'  => Mapel::count(),
            'chart_kelas'  => Siswa::select('kelas', DB::raw('count(*) as total'))
                                   ->groupBy('kelas')->orderBy('kelas')->get(),
            'chart_nilai'  => Nilai::select('status', DB::raw('count(*) as total'))
                                   ->groupBy('status')->get(),
        ];
        return view('admin.dashboard', $data);
    }

    // ─── Data Siswa ─────────────────────────────────────────────
    public function dataSiswa(Request $request)
    {
        $search = $request->get('search');
        $siswa  = Siswa::with('user')
                       ->when($search, fn($q) => $q->where('nama_siswa', 'like', "%$search%")
                                                    ->orWhere('nis', 'like', "%$search%")
                                                    ->orWhere('kelas', 'like', "%$search%"))
                       ->orderBy('kelas')->orderBy('nama_siswa')
                       ->paginate(15)->withQueryString();
        return view('admin.siswa.index', compact('siswa', 'search'));
    }

    public function createSiswa()
    {
        return view('admin.siswa.create');
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nis'        => 'required|string|max:20|unique:siswa,nis',
            'nama_siswa' => 'required|string|max:50',
            'kelas'      => 'required|string|max:10',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'siswa',
            ]);
            Siswa::create([
                'id_user'    => $user->id_user,
                'nis'        => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'kelas'      => $request->kelas,
            ]);
        });

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function editSiswa($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $request->validate([
            'nis'        => 'required|string|max:20|unique:siswa,nis,' . $id . ',id_siswa',
            'nama_siswa' => 'required|string|max:50',
            'kelas'      => 'required|string|max:10',
            'email'      => 'required|email|unique:users,email,' . $siswa->id_user . ',id_user',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            $siswa->update([
                'nis'        => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'kelas'      => $request->kelas,
            ]);
            $updateUser = ['email' => $request->email];
            if ($request->filled('password')) {
                $updateUser['password'] = Hash::make($request->password);
            }
            $siswa->user->update($updateUser);
        });

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->user->delete(); // Cascade hapus siswa juga
        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil dihapus.');
    }

    // ─── Data Guru ──────────────────────────────────────────────
    public function dataGuru(Request $request)
    {
        $search = $request->get('search');
        $guru   = Guru::with(['user', 'mapel'])
                      ->when($search, fn($q) => $q->where('nama_guru', 'like', "%$search%")
                                                   ->orWhere('nip', 'like', "%$search%"))
                      ->orderBy('nama_guru')
                      ->paginate(15)->withQueryString();
        return view('admin.guru.index', compact('guru', 'search'));
    }

    public function createGuru()
    {
        $mapel = Mapel::orderBy('nama_mapel')->get();
        return view('admin.guru.create', compact('mapel'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'nip'       => 'required|string|max:20|unique:guru,nip',
            'nama_guru' => 'required|string|max:50',
            'id_mapel'  => 'required|exists:mapel,id_mapel',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'guru',
            ]);
            Guru::create([
                'id_user'   => $user->id_user,
                'nip'       => $request->nip,
                'nama_guru' => $request->nama_guru,
                'id_mapel'  => $request->id_mapel,
            ]);
        });

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function editGuru($id)
    {
        $guru  = Guru::with('user')->findOrFail($id);
        $mapel = Mapel::orderBy('nama_mapel')->get();
        return view('admin.guru.edit', compact('guru', 'mapel'));
    }

    public function updateGuru(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $request->validate([
            'nip'       => 'required|string|max:20|unique:guru,nip,' . $id . ',id_guru',
            'nama_guru' => 'required|string|max:50',
            'id_mapel'  => 'required|exists:mapel,id_mapel',
            'email'     => 'required|email|unique:users,email,' . $guru->id_user . ',id_user',
        ]);

        DB::transaction(function () use ($request, $guru) {
            $guru->update([
                'nip'       => $request->nip,
                'nama_guru' => $request->nama_guru,
                'id_mapel'  => $request->id_mapel,
            ]);
            $updateUser = ['email' => $request->email];
            if ($request->filled('password')) {
                $updateUser['password'] = Hash::make($request->password);
            }
            $guru->user->update($updateUser);
        });

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroyGuru($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->user->delete();
        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil dihapus.');
    }

    // ─── E-Rapor / Input Nilai ──────────────────────────────────
    public function eRapor(Request $request)
    {
        $siswa  = Siswa::orderBy('kelas')->orderBy('nama_siswa')->get();
        $mapel  = Mapel::orderBy('nama_mapel')->get();
        $guru   = Guru::with('mapel')->orderBy('nama_guru')->get();
        $kelas  = Siswa::distinct()->orderBy('kelas')->pluck('kelas');

        $nilai  = Nilai::with(['siswa', 'mapel', 'guru'])
                       ->when($request->kelas,  fn($q) => $q->where('kelas', $request->kelas))
                       ->when($request->id_mapel, fn($q) => $q->where('id_mapel', $request->id_mapel))
                       ->when($request->tahun_ajaran, fn($q) => $q->where('tahun_ajaran', $request->tahun_ajaran))
                       ->orderBy('kelas')
                       ->paginate(20)->withQueryString();

        return view('admin.erapor', compact('siswa', 'mapel', 'guru', 'kelas', 'nilai'));
    }

    public function siswaByKelas(Request $request)
    {
        $siswa = Siswa::where('kelas', $request->kelas)
                    ->orderBy('nama_siswa')
                    ->get(['id_siswa', 'nama_siswa', 'nis', 'kelas']);
        return response()->json($siswa);
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'id_siswa'     => 'required|exists:siswa,id_siswa',
            'id_guru'      => 'required|exists:guru,id_guru',
            'id_mapel'     => 'required|exists:mapel,id_mapel',
            'kelas'        => 'required|string|max:10',
            'nilai_tugas'  => 'required|numeric|min:0|max:100',
            'nilai_uts'    => 'required|numeric|min:0|max:100',
            'nilai_uas'    => 'required|numeric|min:0|max:100',
            'tahun_ajaran' => 'required|string|max:25',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        $nilaiAkhir = Nilai::hitungNilaiAkhir($request->nilai_tugas, $request->nilai_uts, $request->nilai_uas);
        $status     = Nilai::tentukanStatus($nilaiAkhir);

        // Cek apakah sudah ada nilai untuk kombinasi ini
        $existing = Nilai::where([
            'id_siswa'     => $request->id_siswa,
            'id_mapel'     => $request->id_mapel,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
        ])->first();

        if ($existing) {
            $existing->update(array_merge($request->only([
                'id_guru', 'kelas', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'tahun_ajaran', 'semester'
            ]), ['nilai_akhir' => $nilaiAkhir, 'status' => $status]));
        } else {
            Nilai::create(array_merge($request->only([
                'id_siswa', 'id_guru', 'id_mapel', 'kelas', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'tahun_ajaran', 'semester'
            ]), ['nilai_akhir' => $nilaiAkhir, 'status' => $status]));
        }

        return redirect()->route('admin.erapor')->with('success', 'Nilai berhasil disimpan.');
    }

    // ─── Rekap / Laporan Nilai ──────────────────────────────────
    public function rekapNilai(Request $request)
    {
        $kelas  = Siswa::distinct()->orderBy('kelas')->pluck('kelas');
        $mapel  = Mapel::orderBy('nama_mapel')->get();
        $tahunList = Nilai::distinct()->orderByDesc('tahun_ajaran')->pluck('tahun_ajaran');

        $nilai = Nilai::with(['siswa', 'mapel', 'guru'])
                      ->when($request->kelas, fn($q) => $q->where('kelas', $request->kelas))
                      ->when($request->id_mapel, fn($q) => $q->where('id_mapel', $request->id_mapel))
                      ->when($request->tahun_ajaran, fn($q) => $q->where('tahun_ajaran', $request->tahun_ajaran))
                      ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
                      ->orderBy('kelas')->orderBy('id_siswa')
                      ->paginate(20)->withQueryString();

        return view('admin.rekapnilai', compact('kelas', 'mapel', 'tahunList', 'nilai'));
    }

    // ─── Mata Pelajaran ─────────────────────────────────────────
    public function dataMapel()
    {
        $mapel = Mapel::withCount('guru')->orderBy('nama_mapel')->get();
        return view('admin.mapel', compact('mapel'));
    }

    public function storeMapel(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mapel,kode_mapel',
            'nama_mapel' => 'required|string|max:50',
            'deskripsi'  => 'nullable|string',
        ]);
        Mapel::create($request->only(['kode_mapel', 'nama_mapel', 'deskripsi']));
        return redirect()->route('admin.mapel')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function destroyMapel($id)
    {
        Mapel::findOrFail($id)->delete();
        return redirect()->route('admin.mapel')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}