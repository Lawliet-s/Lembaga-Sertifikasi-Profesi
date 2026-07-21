<?php

use App\Http\Controllers\AsesiController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\AsesorController;
use App\Http\Controllers\AsesorDashboardController;
use App\Http\Controllers\AuthImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Beranda_img1Controller;
use App\Http\Controllers\Beranda_img2Controller;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Dashboard_adminController;
use App\Http\Controllers\Dashboard_asesiController;
use App\Http\Controllers\DeleteGaleriFotoController;
use App\Http\Controllers\F_profilController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FilelainController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\KkniController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\SkkniController;
use App\Http\Controllers\StrorgController;
use App\Http\Controllers\TukController;
use App\Http\Controllers\UiController;
use App\Http\Controllers\UiFotosController;
use App\Http\Controllers\UnikomController;
use App\Http\Controllers\Upload_DokumenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\XnxxController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\JadwalController;


Route::get('pdf', [UiController::class, 'pdf'])->name('pdf');

Route::get('loginadmin', [ClientController::class, 'loginadmin'])->name('loginadmin');
Route::get('registrasi_Authentification', [ClientController::class, 'reg'])->name('reg');

// =============== ASESOR LOGIN ===============
Route::get('loginasesor', [App\Http\Controllers\AsesorAuthController::class, 'loginForm'])->name('loginasesor');
Route::post('asesor-login', [App\Http\Controllers\AsesorAuthController::class, 'login'])->name('asesor.login')->middleware('throttle:login');
Route::post('asesor-logout', [App\Http\Controllers\AsesorAuthController::class, 'logout'])->name('asesor.logout');

Route::get('404', [UiController::class, 'notfound'])->name('404');

// =============== CLIENT NEW ===============
Route::get('/', [ClientController::class, 'clientutama'])->name('/');
Route::get('tentang', [ClientController::class, 'tentang'])->name('tentang');
Route::get('tutorial', [ClientController::class, 'tutorial'])->name('tutorial');
Route::get('logo', [ClientController::class, 'logo'])->name('logo');
Route::get('kontak', [ClientController::class, 'kontak'])->name('kontak');
Route::get('pengelola', [ClientController::class, 'pengelola'])->name('pengelola');
Route::get('pengelola_detail/{pengelola_detail}', [ClientController::class, 'pengelola_detail'])->name('pengelola_detail');
Route::get('struktur', [ClientController::class, 'struktur'])->name('struktur');
Route::get('jadwal-asesmen', [ClientController::class, 'jadwal'])->name('client_jadwal');
Route::get('visi', [ClientController::class, 'visi'])->name('visi');
Route::get('download', [ClientController::class, 'download'])->name('download');
Route::get('client_skkni', [ClientController::class, 'skkni'])->name('client_skkni');
Route::get('client_kkni', [ClientController::class, 'kkni'])->name('client_kkni');
Route::get('client_filelain', [ClientController::class, 'filelain'])->name('client_filelain');
Route::get('client_formulir', [ClientController::class, 'formulir'])->name('client_formulir');
Route::get('client_skema', [ClientController::class, 'skema'])->name('client_skema');
Route::get('skema_detail/{skema_detail}', [ClientController::class, 'skema_detail'])->name('skema_detail');
Route::get('client_tuk', [ClientController::class, 'tuk'])->name('client_tuk');
Route::get('tuk_detail/{tuk_detail}', [ClientController::class, 'tuk_detail'])->name('tuk_detail');
Route::get('client_sertifikat', [ClientController::class, 'sertifikat'])->name('client_sertifikat');
Route::get('client_asesor', [ClientController::class, 'asesor'])->name('client_asesor');
Route::get('asesor_detail/{asesor_detail}', [ClientController::class, 'asesor_detail'])->name('asesor_detail');
Route::get('client_berita', [ClientController::class, 'berita'])->name('client_berita');
Route::get('berita_detail/{berita_detail}', [ClientController::class, 'berita_detail'])->name('berita_detail');
Route::get('client_galeri', [ClientController::class, 'galeri'])->name('client_galeri');
Route::get('galeri_detail/{galeri_detail}', [ClientController::class, 'galeri_detail'])->name('galeri_detail');

// =============== CLIENT OLD ===============
Route::get('profil', [UiController::class, 'profil'])->name('profil.front');
Route::get('show_artikel_berita', [UiController::class, 'berita_list'])->name('berita.list');
Route::get('show_pengumuman', [UiController::class, 'pengumuman_list'])->name('pengumuman.list');
Route::get('uiskemas/{uiskema}', [UiController::class, 'uiskema_show'])->name('uiskema.show');
Route::get('tampil_skema', [UiController::class, 'tampil_skema'])->name('tampil.skema');
Route::get('berita_tampil/{berita_tampil}', [UiController::class, 'berita_tampil'])->name('berita.tampil');
Route::get('file_download', [UiController::class, 'file'])->name('file.tampil');
Route::resource('uifoto', UiFotosController::class);

Auth::routes();

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->middleware('throttle:login')
    ->name('login');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
    ->middleware(['throttle:register', 'honeypot'])
    ->name('register');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('throttle:password-reset')
    ->name('password.email');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
    ->middleware('throttle:password-reset')
    ->name('password.update');

// =============== ADMIN WEB ===============
Route::group(['middleware' => ['role:admin', 'throttle:admin', 'honeypot']], function () {
    // <------------------ PROFIL SAYA  ------------------>
    Route::get('admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    // <------------------  DASHBOARD  ------------------>
    Route::resource('admin', Dashboard_adminController::class);
    // <------------------ SKEMA  ------------------>
    Route::resource('skema', SkemaController::class);
    Route::get('show_asesmen/{id}', [SkemaController::class, 'show_asesmen'])->name('show_asesmen');
    Route::get('detail/{id}', [SkemaController::class, 'detail'])->name('skema.detail');
    Route::post('verifikasi_skema',[SkemaController::class, 'verifikasi_skema'])->name('verifikasi_skema');
    // <------------------ LAYANAN  ------------------>
    Route::resource('jurusan', JurusanController::class);
    Route::resource('asesor', AsesorController::class);
    Route::resource('tuk', TukController::class);
    Route::resource('unikom', UnikomController::class);
    Route::resource('asesmen', AsesmenController::class);
    // <------------------ PENGGUNA  ------------------>
    Route::resource('user', UserController::class);
    Route::put('user_update2/{user_update2}', [UserController::class, 'user_update2'])->name('user_update2');
    // <------------------ DATA REGISTRASI  ------------------>
    Route::resource('validasi', ValidasiController::class);
    Route::get('validasi2/{validasi}/edit', [ValidasiController::class, 'index_edit'])->name('validasi.edit2');
    Route::get('registrasi_baru', [ValidasiController::class, 'registrasi_baru'])->name('registrasi.baru');
    Route::get('proses_show/{proses_show}', [ValidasiController::class, 'proses_show'])->name('proses_show');
    Route::get('sertifikat_show/{sertifikat_show}', [ValidasiController::class, 'sertifikat_show'])->name('sertifikat_show');
    Route::get('blacklist_show/{blacklist_show}', [ValidasiController::class, 'blacklist_show'])->name('blacklist_show');
    Route::get('pengguna_ditolak', [ValidasiController::class, 'list_tolak'])->name('list.tolak');
    Route::get('pengguna_divalidasi', [ValidasiController::class, 'list_valid'])->name('list.valid');
    Route::get('pengguna_bersertifikat', [ValidasiController::class, 'list_sertifikat'])->name('list.sertifikat');
    Route::get('pengguna_diblacklist', [ValidasiController::class, 'list_blacklist'])->name('list.blacklist');
    Route::put('update2/{update2}', [ValidasiController::class, 'update2'])->name('finish.update');
    Route::put('tolak/{tolak}', [ValidasiController::class, 'update3'])->name('tolak.update');
    Route::put('validasi/{validasi}/status', [ValidasiController::class, 'updateStatus'])->name('validasi.status');
    // <------------------ GALERI  ------------------>
    Route::resource('galeri', GaleriController::class);
    Route::resource('dashadmin', Dashboard_adminController::class);
    Route::resource('delete_galeri_foto', DeleteGaleriFotoController::class);
    Route::post('upload_foto', [GaleriController::class, 'foto_store'])->name('foto.store');
    // <------------------ BERITA  ------------------>
    Route::resource('berita', BeritaController::class);
    Route::resource('info', InfoController::class);
    Route::put('save_image/{save_image}', [InfoController::class, 'save_image'])->name('save_image');
    // <------------------ TUTORIAL / PROSEDUR SERTIFIKASI  ------------------>
    Route::resource('data-tutorial', TutorialController::class)->parameters(['data-tutorial' => 'tutorial'])->names('tutorial');
    // <------------------ JADWAL ASESMEN  ------------------>
    Route::resource('jadwal', JadwalController::class);
    // <------------------ FILE UPLOAD  ------------------>
    Route::resource('file', FileController::class);
    Route::resource('skkni', SkkniController::class);
    Route::get('skkni_detail/{skkni_detail}', [SkkniController::class, 'skkni_detail'])->name('skkni_detail');
    Route::resource('kkni', KkniController::class);
    Route::get('kkni_detail/{kkni_detail}', [kkniController::class, 'kkni_detail'])->name('kkni_detail');
    Route::resource('filelain', FilelainController::class);
    Route::get('filelain_detail/{filelain_detail}', [FilelainController::class, 'filelain_detail'])->name('filelain_detail');
    // <------------------  PERMOHONAN SERTIFIKASI redirect  ------------------>
    Route::permanentRedirect('permohonan-sertifikasi', 'registrasi_baru');
    //  <------------------ NOTE  ------------------>
    Route::resource('note', NoteController::class);
    //  <------------------ FRONT SETTING  ------------------>
    Route::resource('sett-beranda', UiController::class);
    Route::resource('beranda_img1', Beranda_img1Controller::class);
    Route::resource('beranda_img2', Beranda_img2Controller::class);
    Route::resource('f_profil', F_profilController::class);
    Route::resource('strorg', StrorgController::class);
    Route::resource('site_setting', SiteSettingController::class);
    Route::post('upload', [GaleriController::class, 'upload'])->name('upload');
    Route::post('finishstore', [ValidasiController::class, 'finishstore'])->name('finishstore');
    //  <------------------ GAMBAR AUTH  ------------------>
    Route::get('auth-images', [AuthImageController::class, 'index'])->name('auth.images.index');
    Route::put('auth-images', [AuthImageController::class, 'update'])->name('auth.images.update');
    //  <------------------ POST  ------------------>
    Route::resource('post', PostController::class);
});


// =============== ASESION ===============
Route::group(['middleware' => ['auth', 'role:asesi', 'throttle:asesi', 'honeypot']], function () {
    //  <------------------ REGISTER  ------------------>
    Route::resource('dashasesi', Dashboard_asesiController::class);
    Route::resource('asesi', AsesiController::class);
    Route::resource('registrasi', RegistrasiController::class);
    Route::get('skema_pendaftaran', [RegistrasiController::class, 'skema_pendaftaran'])->name('skema_pendaftaran');
    Route::resource('pendaftaran', XnxxController::class);

    Route::get('daftar', [RegistrasiController::class, 'daftar'])->name('daftar');
    // <------------------ ASSESMENT  ------------------>
    Route::get('info_skema', [AsesiController::class, 'info_skema'])->name('info.skema');
    Route::get('info_skema/show/{id}', [AsesiController::class, 'info_skema_show'])->name('info_skema.show');
    Route::get('koleksi_sertifikat', [AsesiController::class, 'koleksi_sertifikat'])->name('koleksi.sertifikat');
    Route::get('instruksi_registrasi', [AsesiController::class, 'instruksi_registrasi'])->name('instruksi.registrasi');
    // <------------------ XNXX  ------------------>
    Route::post('for_apl2', [XnxxController::class, 'token_store'])->name('token.store');
    Route::post('Registrasi_Validate', [XnxxController::class, 'token2_store'])->name('token2.store');
    Route::get('rekap_registrasi', [XnxxController::class, 'rekap_registrasi'])->name('rekap.registrasi');
    Route::delete('register/{register}', [XnxxController::class, 'destroy2'])->name('register.destroy');
    Route::resource('identitas', Upload_DokumenController::class);
    Route::get('sertifikat_show/{id}', [AsesiController::class, 'sertifikat_show'])->name('asesi.sertifikat_show');
    Route::get('rekap_pendaftaran/{id}', [RegistrasiController::class, 'rekap_pendaftaran'])->name('rekap_pendaftaran');
    Route::get('info_sertifikasi/{id}', [RegistrasiController::class, 'info_sertifikasi'])->name('info_sertifikasi');
    Route::get('data_edit_tolak/{id}', [RegistrasiController::class, 'data_edit_tolak'])->name('data_edit_tolak');
    // <------------------  PERMOHONAN SERTIFIKASI  ------------------>
    Route::resource('permohonan', PermohonanController::class);
    Route::get('get-unit-kompetensi/{skemaId}', [PermohonanController::class, 'getUnitKompetensi'])->name('get.unit.kompetensi');
     Route::get('frapl01', [PermohonanController::class, 'frapl01'])->name('permohonan.frapl01');
     Route::get('frapl01/{id}', [PermohonanController::class, 'showFrapl01'])->name('permohonan.frapl01.show');
     // <------------------  FR.AK.04  ------------------>
     Route::get('frak04', [\App\Http\Controllers\FrAk04Controller::class, 'index'])->name('frak04.index');
     Route::get('frak04/{data_register}', [\App\Http\Controllers\FrAk04Controller::class, 'show'])->name('frak04.show');
     Route::post('frak04/{data_register}', [\App\Http\Controllers\FrAk04Controller::class, 'store'])->name('frak04.store');
    // <------------------  FR.APL.02  ------------------>
    Route::get('apl02', [\App\Http\Controllers\Apl02Controller::class, 'index'])->name('apl02.index');
    Route::get('apl02/create/{id}', [\App\Http\Controllers\Apl02Controller::class, 'create'])->name('apl02.create');
    Route::post('apl02/store', [\App\Http\Controllers\Apl02Controller::class, 'store'])->name('apl02.store');
    Route::get('apl02/{id}', [\App\Http\Controllers\Apl02Controller::class, 'show'])->name('apl02.show');
    // <------------------ PROFIL ASESI ------------------>
    Route::get('edit', [AsesiController::class, 'edit'])->name('profil.edit');
    Route::put('edit', [AsesiController::class, 'update'])->name('profil.update');

});


// =============== AUTH ===============
Route::get('asesion', [App\Http\Controllers\HomeController::class, 'index3'])->name('asesion');
Route::middleware('role:admin')->get('admin', [App\Http\Controllers\Dashboard_adminController::class, 'index'])->name('admin');
Route::middleware(['role:asesor', 'throttle:asesor'])->prefix('dashboard-asesor')->group(function () {
    Route::get('/', [AsesorDashboardController::class, 'index'])->name('dashboard.asesor');
    Route::get('profil', [AsesorDashboardController::class, 'profil'])->name('asesor.profil');
    Route::put('profil', [AsesorDashboardController::class, 'updateProfil'])->name('asesor.profil.update');
    Route::get('penilaian', [AsesorDashboardController::class, 'penilaian'])->name('asesor.penilaian');
    Route::get('penilaian/{register}', [AsesorDashboardController::class, 'penilaianShow'])->name('asesor.penilaian.show');
    Route::post('penilaian/{register}/update', [AsesorDashboardController::class, 'updatePenilaian'])->name('asesor.penilaian.update');
    Route::get('observasi', [AsesorDashboardController::class, 'observasiIndex'])->name('asesor.observasi');
    Route::get('observasi/{register}', [AsesorDashboardController::class, 'observasi'])->name('asesor.observasi.show');
    Route::post('observasi/{register}', [AsesorDashboardController::class, 'storeObservasi'])->name('asesor.observasi.store');
    Route::get('validasi', [AsesorDashboardController::class, 'validasi'])->name('asesor.validasi');
    Route::get('validasi/{register}', [AsesorDashboardController::class, 'validasiShow'])->name('asesor.validasi.show');
    Route::post('validasi/{register}', [AsesorDashboardController::class, 'storeValidasi'])->name('asesor.validasi.store');
    Route::get('rekomendasi', [AsesorDashboardController::class, 'rekomendasi'])->name('asesor.rekomendasi');
    Route::get('rekomendasi/{register}', [AsesorDashboardController::class, 'rekomendasiShow'])->name('asesor.rekomendasi.show');
    Route::post('rekomendasi/{register}', [AsesorDashboardController::class, 'storeRekomendasi'])->name('asesor.rekomendasi.store');
    Route::get('rekomendasi/{register}/pdf/{type}', [AsesorDashboardController::class, 'generatePdf'])->name('asesor.rekomendasi.pdf');
});
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('skema1', [HomeController::class, 'skema1'])->name('skema1');
Route::get('list', [HomeController::class, 'list'])->name('list');
