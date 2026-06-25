<?php

namespace App\Http\Controllers;

use App\Models\Data_register;
use App\Models\Info;
use App\Models\Info2;
use App\Models\Jurusan;
use App\Models\Skema;
use App\Models\Upload_file;
use App\Models\Xnxx;
use Illuminate\Http\Request;

class Dashboard_asesiController extends Controller
{

    public function index()
    {
        $xnxx = Xnxx::all();
        $info = Info::all();
        $info2 = Info2::all();
        $skema = Skema::where('status_id', '1')->get();
        $jurusan = Jurusan::all();
        $datasertifikat = Data_register::where('nik', auth()->user()->nik)
            ->where('status', 'LIKE', '%Sertifikasi Selesai%')->count();
        $upload = Upload_file::where('user_id', auth()->user()->id)->get();
        $datareg = Data_register::where('user_id', auth()->user()->id)
            ->where('status', 'LIKE', '%Lengkapi Data Anda%')
            ->get();
        $datareg1 = Data_register::where('user_id', auth()->user()->id)
            ->where('status', 'LIKE', '%Menunggu Validasi%')
            ->get();
        $datareg2 = Data_register::where('user_id', auth()->user()->id)
            ->where('status', 'LIKE', '%Pendaftaran Divalidasi%')
            ->get();
        $datareg3 = Data_register::where('user_id', auth()->user()->id)
            ->where('status', 'LIKE', '%Pendaftaran Ditolak%')
            ->get();
        $datareg4 = Data_register::where('nik', auth()->user()->nik)
            ->where('status', 'LIKE', '%Sertifikasi Selesai%')->get();
        $datareg5 = Data_register::where('nik', auth()->user()->nik)
            ->where('status', 'LIKE', '%Pendaftaran Sementara Diblokir%')->get();
        return view('asesion', compact
        (
            'datareg',
            'datareg1',
            'datareg2',
            'datareg3',
            'datareg4',
            'datareg5',
            'datasertifikat',
            'xnxx',
            'skema',
            'info',
            'info2',
            'jurusan',
            'upload',
        ));
    }


}
