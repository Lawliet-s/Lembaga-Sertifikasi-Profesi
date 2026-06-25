<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Data_register;
use App\Models\Observasi;
use App\Models\Penilaian;
use App\Models\Tuk;
use App\Models\Unikom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AsesorDashboardController extends Controller
{
    /**
     * Middleware untuk memastikan user adalah asesor
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:asesor']);
    }

    /**
     * Tampilkan dashboard asesor
     */
    public function index()
    {
        $userId = Auth::id();

        $semuaData = Data_register::where('asesor_id', $userId)
            ->with('tuk')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalAsesi = $semuaData->count();

        $jadwalHariIni = $semuaData->filter(function ($item) {
            return $item->date && $item->date->isToday();
        })->count();

        $penilaianBelumSelesai = $semuaData->filter(function ($item) {
            $s = strip_tags($item->status ?? '');
            return !in_array($s, ['Kompeten', 'Belum Kompeten', 'Perlu Asesmen Ulang', 'Sertifikasi Selesai']);
        })->count();

        $sertifikasiDirekomendasikan = $semuaData->where('status', 'Kompeten')->count();

        $totalTuk = Tuk::count();

        $aktivitas = $semuaData->take(5);

        return view('asesor.dashboard', compact(
            'totalAsesi', 'jadwalHariIni', 'penilaianBelumSelesai',
            'sertifikasiDirekomendasikan', 'totalTuk', 'aktivitas'
        ));
    }

    private function findAsesiRegisterOrFail($id)
    {
        return Data_register::where('asesor_id', Auth::id())->findOrFail($id);
    }

    public function penilaian()
    {
        $participants = Data_register::where('asesor_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('asesor.penilaian', compact('participants'));
    }

    public function observasiIndex()
    {
        $participants = Data_register::where('asesor_id', Auth::id())
            ->with('observasis', 'penilaians')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('asesor.observasi_index', compact('participants'));
    }

    public function penilaianShow($id)
    {
        $register = $this->findAsesiRegisterOrFail($id);
        $unikoms = collect();
        if ($register->skema_id) {
            $unikoms = Unikom::where('skema_id', $register->skema_id)->get();
        }
        $penilaians = $register->penilaians()->get()->keyBy('unikom_id');

        return view('asesor.penilaian_show', compact('register', 'unikoms', 'penilaians'));
    }

    public function updatePenilaian(Request $request, $id)
    {
        $register = $this->findAsesiRegisterOrFail($id);

        $request->validate([
            'keterangan' => ['nullable', 'string', 'max:500'],
            'penilaian' => ['required', 'array'],
            'penilaian.*' => ['required', 'in:kompeten,belum'],
        ]);

        foreach ($request->penilaian as $unikomId => $nilai) {
            Penilaian::updateOrCreate(
                [
                    'data_register_id' => $register->id,
                    'unikom_id' => $unikomId,
                ],
                ['nilai' => $nilai]
            );
        }

        $allKompeten = collect($request->penilaian)->every(fn($v) => $v === 'kompeten');

        $register->update([
            'status' => $allKompeten ? 'Kompeten' : 'Belum Kompeten',
            'keterangan' => $request->keterangan,
            'asesor_id' => Auth::id(),
        ]);

        return redirect()->route('asesor.penilaian.show', $register->id)
            ->with('success', 'Penilaian asesi berhasil disimpan.');
    }

    public function observasi($id)
    {
        $register = $this->findAsesiRegisterOrFail($id);
        $observasi = $register->observasis()->latest()->first();
        $penilaians = $register->penilaians()->with('unikom')->get();

        $unikoms = collect();
        if ($register->skema_id) {
            $unikoms = Unikom::where('skema_id', $register->skema_id)->get();
        }

        $aktivitasList = $observasi->aktivitas ?? [['nama' => '', 'hasil' => 'Baik']];

        return view('asesor.observasi', compact('register', 'observasi', 'penilaians', 'unikoms', 'aktivitasList'));
    }

    public function storeObservasi(Request $request, $id)
    {
        $register = $this->findAsesiRegisterOrFail($id);

        $request->validate([
            'aktivitas' => ['required', 'array', 'min:1'],
            'aktivitas.*.nama' => ['required', 'string', 'max:255'],
            'aktivitas.*.hasil' => ['required', 'in:Baik,Kurang,Cukup'],
            'catatan' => ['nullable', 'string', 'max:2000'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('observasi', 'public');
        }

        Observasi::create([
            'data_register_id' => $register->id,
            'aktivitas' => $request->aktivitas,
            'catatan' => $request->catatan,
            'file' => $filePath,
        ]);

        $register->update([
            'koreksi' => $request->catatan,
            'asesor_id' => Auth::id(),
        ]);

        return redirect()->route('asesor.observasi.show', $register->id)
            ->with('success', 'Hasil observasi berhasil disimpan.');
    }

    public function validasi()
    {
        $participants = Data_register::where('asesor_id', Auth::id())
            ->with('observasis', 'penilaians')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('asesor.validasi_index', compact('participants'));
    }

    public function validasiShow($id)
    {
        $register = $this->findAsesiRegisterOrFail($id);
        $observasi = $register->observasis()->latest()->first();
        $penilaians = $register->penilaians()->with('unikom')->get();

        $totalKompeten = $penilaians->where('nilai', 'kompeten')->count();
        $totalBelum = $penilaians->where('nilai', 'belum')->count();

        $validasiData = $register->validasi_data ?? [
            'checklist' => [
                'bukti_lengkap' => false,
                'observasi_sesuai' => false,
                'nilai_konsisten' => false,
            ],
            'status_akhir' => null,
        ];

        return view('asesor.validasi', compact('register', 'observasi', 'penilaians', 'totalKompeten', 'totalBelum', 'validasiData'));
    }

    public function storeValidasi(Request $request, $id)
    {
        $register = $this->findAsesiRegisterOrFail($id);

        $request->validate([
            'checklist' => ['required', 'array'],
            'checklist.bukti_lengkap' => ['required', 'boolean'],
            'checklist.observasi_sesuai' => ['required', 'boolean'],
            'checklist.nilai_konsisten' => ['required', 'boolean'],
            'status_akhir' => ['required', 'in:Kompeten,Belum Kompeten'],
        ]);

        $allChecked = $request->checklist['bukti_lengkap']
            && $request->checklist['observasi_sesuai']
            && $request->checklist['nilai_konsisten'];

        $register->update([
            'validasi_data' => [
                'checklist' => $request->checklist,
                'status_akhir' => $request->status_akhir,
            ],
            'status' => $allChecked ? $request->status_akhir : 'Validasi Ditolak',
            'asesor_id' => Auth::id(),
        ]);

        return redirect()->route('asesor.validasi.show', $register->id)
            ->with('success', 'Validasi kompetensi berhasil disimpan.');
    }

    public function rekomendasi()
    {
        $participants = Data_register::where('asesor_id', Auth::id())
            ->with('observasis', 'penilaians')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('asesor.rekomendasi_index', compact('participants'));
    }

    public function rekomendasiShow($id)
    {
        $register = $this->findAsesiRegisterOrFail($id);
        $observasi = $register->observasis()->latest()->first();
        $penilaians = $register->penilaians()->with('unikom')->get();

        $totalKompeten = $penilaians->where('nilai', 'kompeten')->count();
        $totalBelum = $penilaians->where('nilai', 'belum')->count();

        $rekomendasiData = $register->rekomendasi_data ?? [
            'keputusan' => null,
            'catatan' => null,
        ];

        return view('asesor.rekomendasi', compact(
            'register', 'observasi', 'penilaians',
            'totalKompeten', 'totalBelum', 'rekomendasiData'
        ));
    }

    public function storeRekomendasi(Request $request, $id)
    {
        $register = $this->findAsesiRegisterOrFail($id);

        $request->validate([
            'keputusan' => ['required', 'string', 'in:Direkomendasikan Sertifikasi,Perlu Perbaikan,Mengulang Asesmen'],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ]);

        $register->update([
            'rekomendasi_data' => [
                'keputusan' => $request->keputusan,
                'catatan' => $request->catatan,
            ],
            'status' => $request->keputusan === 'Direkomendasikan Sertifikasi' ? 'Sertifikasi Selesai' : $request->keputusan,
            'keterangan' => $request->catatan,
            'asesor_id' => Auth::id(),
        ]);

        return redirect()->route('asesor.rekomendasi.show', $register->id)
            ->with('success', 'Rekomendasi sertifikasi berhasil disimpan.');
    }

    public function generatePdf($id, $type)
    {
        $register = $this->findAsesiRegisterOrFail($id);
        $observasi = $register->observasis()->latest()->first();
        $penilaians = $register->penilaians()->with('unikom')->get();

        $totalKompeten = $penilaians->where('nilai', 'kompeten')->count();
        $totalBelum = $penilaians->where('nilai', 'belum')->count();

        $rekomendasiData = $register->rekomendasi_data ?? [];

        $view = $type === 'berita-acara'
            ? 'asesor.pdf_berita_acara'
            : 'asesor.pdf_hasil_asesmen';

        $pdf = Pdf::loadView($view, compact(
            'register', 'observasi', 'penilaians',
            'totalKompeten', 'totalBelum', 'rekomendasiData'
        ));

        $filename = $type === 'berita-acara'
            ? 'berita_acara_' . ($register->user_name ?? 'asesi') . '.pdf'
            : 'hasil_asesmen_' . ($register->user_name ?? 'asesi') . '.pdf';

        return $pdf->download($filename);
    }

    public function profil()
    {
        $user = Auth::user();
        $asesor = Asesor::where('email', $user->email)->first();

        if (!$asesor) {
            $asesor = Asesor::create([
                'nik' => $user->kode ?? $user->id,
                'nama' => $user->name,
                'email' => $user->email,
                'status' => 'Aktif',
            ]);
        }

        return view('asesor.profil', compact('asesor'));
    }
}
