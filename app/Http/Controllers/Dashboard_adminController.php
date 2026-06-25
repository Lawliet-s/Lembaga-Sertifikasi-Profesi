<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Berita;
use App\Models\Data_register;
use App\Models\Galeri_foto;
use App\Models\Group_galeri;
use App\Models\Skema;
use App\Models\Tuk;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard_adminController extends Controller
{

    public function index()
    {
        $datatuk = Tuk::count();   
        $dataasesor = Asesor::count();  
        $dataskema = Skema::all()->count();  
        $datauser = User::all()->count();
        $datasertifikat = Data_register::where('status', 'LIKE', '%Sertifikasi Selesai%')->count();        
        $datatolak = Data_register::where('status', 'LIKE', '%Pendaftaran Ditolak%')->count();
        $databaru = Data_register::where('status', 'LIKE', '%Menunggu Validasi%')->count();
        $datavalid = Data_register::where('status', 'LIKE', '%Pendaftaran Divalidasi%')->count();
        $datareg = Data_register::all()->count();
        $newreg = Data_register::where('status', 'LIKE', '%Menunggu Validasi%')->take(5)->get();
        $jadwalreg = Data_register::where('status', 'LIKE', '%Pendaftaran Divalidasi%')->take(5)->get();
        $datagaleri = Group_galeri::all()->take(5);
        $datapemegang = Data_register::where('status', 'LIKE', '%Sertifikasi Selesai%')->take(6)->get(); 
        $databerita = Berita::all()->take(4);    
        $image = Galeri_foto::all();   

        return view('admin', compact
        (
            'datareg', 
            'datavalid', 
            'databaru', 
            'datatolak', 
            'datauser', 
            'datasertifikat',
            'dataskema',
            'datatuk',
            'dataasesor',
            'newreg',
            'jadwalreg',
            'datagaleri',
            'datapemegang',
            'databerita',
            'image'
        ));
    }

}
