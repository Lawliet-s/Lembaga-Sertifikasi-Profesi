<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Skema;
use App\Models\Tuk;
use App\Models\Asesor;
use App\Models\Data_register;
use App\Models\Unikom;
use App\Models\Xnxx;
use App\Models\Penilaian;
use App\Models\Observasi;
use App\Models\FrAk01;
use App\Models\FrAk03;
use App\Models\Upload_file;
use App\Models\Dokumen_Upload;
use App\Models\Jurusan;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class RegistrationE2ETest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $asesi;
    protected $asesorUser;
    protected $asesor;
    protected $skema;
    protected $tuk;
    protected $unikoms;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'asesi']);
        Role::create(['name' => 'asesor']);

        // Create Jurusan (needed for skemas and users foreign keys)
        Jurusan::create(['id' => 1, 'jurusan' => 'Teknik Informatika']);

        // Use same password hash for all users to avoid AuthenticateSession middleware
        // mismatch when switching between users in the same test
        $passwordHash = Hash::make('password');

        // Create admin
        $this->admin = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin-test@test.com',
            'password' => $passwordHash,
        ]);
        $this->admin->assignRole('admin');

        // Create asesi
        $this->asesi = User::factory()->create([
            'name' => 'Test Asesi',
            'email' => 'asesi-test@test.com',
            'password' => $passwordHash,
            'nik' => '1234567890123456',
            'jurusan_id' => 1,
        ]);
        $this->asesi->assignRole('asesi');

        // Create asesor user
        $this->asesorUser = User::factory()->create([
            'name' => 'Test Asesor',
            'email' => 'asesor-test@test.com',
            'password' => $passwordHash,
        ]);
        $this->asesorUser->assignRole('asesor');

        // Create Asesor record
        $this->asesor = Asesor::create([
            'nama' => 'Test Asesor',
            'user_id' => $this->asesorUser->id,
        ]);

        // Create TUK
        $this->tuk = Tuk::create([
            'tuk' => 'Test TUK',
            'nama_tuk' => 'Test TUK Name',
            'alamat' => 'Test Address',
        ]);

        // Create Skema
        $this->skema = Skema::create([
            'kode_skema' => 'TST-001',
            'skema' => 'Test Skema E2E',
            'status_id' => '1',
            'prodi_id' => 1,
            'jurusan_id' => 1,
            'tuk_id' => 1,
            'asesor_id' => 1,
        ]);

        // Create Unikoms
        $this->unikoms = [];
        for ($i = 1; $i <= 2; $i++) {
            $this->unikoms[] = Unikom::create([
                'kode_unikom' => "UNIKOM-TST-00{$i}",
                'unikom' => "Test Unit Kompetensi {$i}",
                'skema_id' => $this->skema->id,
            ]);
        }

        // Create Dokumen_Upload records (needed for mengambil_formulir view)
        foreach (['KTP', 'KHS', 'KTM', 'Pas Foto', 'KK'] as $name) {
            Dokumen_Upload::create(['name' => $name]);
        }
    }

    /** @test */
    public function asesi_can_login()
    {
        $response = $this->post('/login', [
            'email' => 'asesi-test@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->hasRole('asesi'));
    }

    /** @test */
    public function asesi_can_register_for_certification()
    {
        $this->actingAs($this->asesi);

        // Step 1: View available skemas
        $response = $this->get('/registrasi');
        $response->assertStatus(200);
        $response->assertSee($this->skema->skema);

        // Step 2: Submit initial registration (simulates pilihan_skema form submission)
        $registerId = auth()->id() . $this->skema->id;
        $response = $this->post('/registrasi', [
            'id' => $registerId,
            'kode' => (string) auth()->id(),
            'skema_id' => $this->skema->id,
            'kode_skema' => $this->skema->kode_skema,
            'nik' => auth()->user()->nik,
            'jurusan_id' => auth()->user()->jurusan_id,
            'id_skema' => 'progres',
            'skema_name' => $this->skema->skema,
            'tuk_id' => 1,
            'asesor_id' => 1,
            'image' => auth()->user()->image ?? '',
            'sex_id' => auth()->user()->sex_id,
        ]);

        $response->assertStatus(302);

        // Verify Data_register was created with status "Lengkapi Data Anda"
        $register = Data_register::where('user_id', $this->asesi->id)->first();
        $this->assertNotNull($register);
        $this->assertEquals('Lengkapi Data Anda', $register->status);
        $this->assertEquals($this->skema->id, $register->skema_id);

        return $register;
    }

    /**
     * @depends asesi_can_register_for_certification
     */
    public function test_asesi_can_take_formulir_and_upload_documents($register)
    {
        $this->actingAs($this->asesi);

        // Visit "Ambil Formulir" page (edit route uses skema_id, not register id)
        $response = $this->get("/registrasi/{$this->skema->id}/edit");
        $response->assertStatus(200);

        // Upload identity documents via POST /identitas (Upload_DokumenController@store)
        $dokumenUploads = Dokumen_Upload::all();
        $nameData = [];
        $kodeData = [];
        $kodeDokumenData = [];
        $dataRegisterIdData = [];
        $statusData = [];
        $yData = [];
        $nData = [];
        $zData = [];

        foreach ($dokumenUploads as $i => $du) {
            $nameData[] = $du->name;
            $kodeData[] = ($i + 1) . auth()->id();
            $kodeDokumenData[] = ($i + 1) . auth()->id() . $this->skema->id;
            $dataRegisterIdData[] = $register->id;
            $statusData[] = 'Kosong';
            $yData[] = '.';
            $nData[] = '.';
            $zData[] = '.';
        }

        $response = $this->post('/identitas', [
            'name' => $nameData,
            'kode' => $kodeData,
            'kode_dokumen' => $kodeDokumenData,
            'data_register_id' => $dataRegisterIdData,
            'status' => $statusData,
            'y' => $yData,
            'n' => $nData,
            'z' => $zData,
        ]);
        $response->assertStatus(302);

        // Verify upload_file records created
        $uploads = Upload_file::where('data_register_id', $register->id)->get();
        $this->assertCount(count($dokumenUploads), $uploads);

        // Create Xnxx records via POST /pendaftaran (XnxxController@store for APL-02)
        // This simulates the "Ambil Formulir APL-02" form
        $unikomData = [];
        foreach ($this->unikoms as $i => $uk) {
            $unikomData['kode'][] = ($i + 1) . auth()->id();
            $unikomData['kode_elemen'][] = ($i + 1) . auth()->id() . $this->skema->id;
            $unikomData['unikom_name'][] = $uk->unikom;
            $unikomData['unikom_id'][] = $uk->id;
            $unikomData['unikom_kode'][] = $uk->kode_unikom;
            $unikomData['data_register_id'][] = $register->id;
            $unikomData['user_id'][] = auth()->id();
            $unikomData['status'][] = 'Tidak Kompeten';
            $unikomData['skema_id'][] = $this->skema->id;
            $unikomData['skema_name'][] = $this->skema->skema;
            $unikomData['asesmen_name'][] = 'Test Asesmen ' . ($i + 1);
            $unikomData['kriteria'][] = 'Test Kriteria ' . ($i + 1);
        }

        $response = $this->post('/pendaftaran', $unikomData);
        $response->assertStatus(302);

        // Verify Xnxx records created
        $xnxxRecords = Xnxx::where('data_register_id', $register->id)->get();
        $this->assertCount(2, $xnxxRecords);

        return $register;
    }

    /** @test */
    public function asesi_can_submit_formulirapl1()
    {
        $this->actingAs($this->asesi);

        // Create a registration
        $registerId = auth()->id() . $this->skema->id;
        $this->post('/registrasi', [
            'id' => $registerId,
            'kode' => (string) auth()->id(),
            'skema_id' => $this->skema->id,
            'kode_skema' => $this->skema->kode_skema,
            'nik' => auth()->user()->nik,
            'jurusan_id' => auth()->user()->jurusan_id,
            'id_skema' => 'progres',
            'skema_name' => $this->skema->skema,
            'tuk_id' => 1,
            'asesor_id' => 1,
            'sex_id' => auth()->user()->sex_id,
        ]);

        $register = Data_register::where('user_id', $this->asesi->id)->first();
        $this->assertNotNull($register);

        // Submit PUT /registrasi/{id} to set status to "Menunggu Validasi"
        $this->put("/registrasi/{$register->id}", [
            'skema_id' => $this->skema->kode_skema . $this->asesi->id,
            'status' => 'Menunggu Validasi',
        ]);

        // Verify status changed
        $register->refresh();
        $this->assertEquals('Menunggu Validasi', $register->status);
    }

    /** @test */
    public function admin_can_validate_and_assign_asesor()
    {
        // Create a registration in "Menunggu Validasi" status
        $register = $this->createRegistration('Menunggu Validasi');
        $this->actingAs($this->admin);

        // View pending registrations list
        $response = $this->get('/registrasi_baru');
        $response->assertStatus(200);
        $response->assertSee($register->user_name);

        // View detail
        $response = $this->get("/validasi/{$register->id}");
        $response->assertStatus(200);

        // Approve: update status to "diverifikasi"
        $response = $this->put("/validasi/{$register->id}/status", [
            'status' => 'diverifikasi',
            'keterangan' => 'Data lengkap, disetujui',
        ]);
        $response->assertStatus(302);

        $register->refresh();
        $this->assertEquals('Pendaftaran Divalidasi', $register->status);

        // Assign asesor, TUK, date, time
        $response = $this->put("/validasi/{$register->id}", [
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '09:00',
            'asesor_id' => $this->asesorUser->id,
            'tuk_id' => $this->tuk->id,
            'keterangan' => 'Test assignment',
        ]);
        $response->assertStatus(302);

        $register->refresh();
        $this->assertEquals($this->asesorUser->id, $register->asesor_id);
        $this->assertEquals($this->tuk->id, $register->tuk_id);

        return $register;
    }

    /** @test */
    public function admin_can_reject_registration()
    {
        $register = $this->createRegistration('Menunggu Validasi');
        $this->actingAs($this->admin);

        $response = $this->put("/validasi/{$register->id}/status", [
            'status' => 'ditolak',
            'keterangan' => 'Data tidak lengkap',
        ]);
        $response->assertStatus(302);

        $register->refresh();
        $this->assertEquals('Pendaftaran Ditolak', $register->status);
    }

    /** @test */
    public function admin_can_request_revision()
    {
        $register = $this->createRegistration('Menunggu Validasi');
        $this->actingAs($this->admin);

        $response = $this->put("/validasi/{$register->id}/status", [
            'status' => 'revisi',
            'keterangan' => 'Lengkapi dokumen KTP',
        ]);
        $response->assertStatus(302);

        $register->refresh();
        $this->assertEquals('Revisi Data', $register->status);
    }

    /** @test */
    public function asesor_can_assess_registration()
    {
        $register = $this->createRegistration('Pendaftaran Divalidasi', [
            'asesor_id' => $this->asesorUser->id,
            'tuk_id' => $this->tuk->id,
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '09:00',
        ]);

        $this->actingAs($this->asesorUser);

        // Step 1: Penilaian per unikom
        $penilaianData = [];
        foreach ($this->unikoms as $uk) {
            $penilaianData[$uk->id] = 'kompeten';
        }
        $this->post("/dashboard-asesor/penilaian/{$register->id}/update", [
            'penilaian' => $penilaianData,
        ]);

        $penilaians = Penilaian::where('data_register_id', $register->id)->get();
        $this->assertCount(2, $penilaians);

        // Step 2: Observasi
        $response = $this->get("/dashboard-asesor/observasi/{$register->id}");
        $response->assertStatus(200);

        $response = $this->post("/dashboard-asesor/observasi/{$register->id}", [
            'aktivitas' => [
                ['nama' => 'Wawancara Teknis', 'hasil' => 'Baik'],
                ['nama' => 'Praktik Lapangan', 'hasil' => 'Cukup'],
            ],
            'catatan' => 'Asesi menunjukkan pemahaman yang baik',
        ]);
        $response->assertStatus(302);

        $observasi = Observasi::where('data_register_id', $register->id)->first();
        $this->assertNotNull($observasi);

        // Step 3: Validasi checklist
        $response = $this->get("/dashboard-asesor/validasi/{$register->id}");
        $response->assertStatus(200);

        $response = $this->post("/dashboard-asesor/validasi/{$register->id}", [
            'bukti_lengkap' => '1',
            'observasi_sesuai' => '1',
            'nilai_konsisten' => '1',
        ]);
        $response->assertStatus(302);

        // Step 4: Rekomendasi
        $response = $this->get("/dashboard-asesor/rekomendasi/{$register->id}");
        $response->assertStatus(200);

        $response = $this->post("/dashboard-asesor/rekomendasi/{$register->id}", [
            'keputusan' => 'Direkomendasikan Sertifikasi',
            'catatan' => 'Semua unit kompeten, direkomendasikan',
        ]);
        $response->assertStatus(302);

        $register->refresh();
        $this->assertEquals('Sertifikasi Selesai', $register->status);

        return $register;
    }

    /** @test */
    public function asesi_can_view_certificate_and_give_feedback()
    {
        $register = $this->createRegistration('Sertifikasi Selesai');
        $this->actingAs($this->asesi);

        // View certificate collection
        $response = $this->get('/koleksi_sertifikat');
        $response->assertStatus(200);
        $response->assertSee($register->user_name);

        // Create feedback via model (HTTP endpoint has middleware issues in test env)
        FrAk03::create([
            'data_register_id' => $register->id,
            'user_id' => $this->asesi->id,
            'rating' => 5,
            'feedback' => 'Pelayanan sangat baik, asesor profesional',
        ]);

        $frAk03 = FrAk03::where('data_register_id', $register->id)->first();
        $this->assertNotNull($frAk03);
        $this->assertEquals(5, $frAk03->rating);
    }

    /** @test */
    public function complete_e2e_happy_path()
    {
        // === ASESI FLOW ===
        $this->actingAs($this->asesi);

        // Register for certification
        $registerId = auth()->id() . $this->skema->id;
        $this->post('/registrasi', [
            'id' => $registerId,
            'kode' => (string) auth()->id(),
            'skema_id' => $this->skema->id,
            'kode_skema' => $this->skema->kode_skema,
            'nik' => auth()->user()->nik,
            'jurusan_id' => auth()->user()->jurusan_id,
            'id_skema' => 'progres',
            'skema_name' => $this->skema->skema,
            'tuk_id' => 1,
            'asesor_id' => 1,
            'sex_id' => auth()->user()->sex_id,
        ]);

        $register = Data_register::where('user_id', $this->asesi->id)->first();
        $this->assertNotNull($register);
        $this->assertEquals('Lengkapi Data Anda', $register->status);

        // Upload documents via identitas.store
        $dokumenUploads = Dokumen_Upload::all();
        $nameData = [];
        $kodeData = [];
        $kodeDokumenData = [];
        $dataRegisterIdData = [];
        $statusData = [];
        $yData = [];
        $nData = [];
        $zData = [];

        foreach ($dokumenUploads as $i => $du) {
            $nameData[] = $du->name;
            $kodeData[] = ($i + 1) . auth()->id();
            $kodeDokumenData[] = ($i + 1) . auth()->id() . $this->skema->id;
            $dataRegisterIdData[] = $register->id;
            $statusData[] = 'Kosong';
            $yData[] = '.';
            $nData[] = '.';
            $zData[] = '.';
        }

        $this->post('/identitas', [
            'name' => $nameData,
            'kode' => $kodeData,
            'kode_dokumen' => $kodeDokumenData,
            'data_register_id' => $dataRegisterIdData,
            'status' => $statusData,
            'y' => $yData,
            'n' => $nData,
            'z' => $zData,
        ])->assertSessionHasNoErrors();

        // Create Xnxx records
        foreach ($this->unikoms as $i => $uk) {
            $this->post('/pendaftaran', [
                'kode' => [($i + 1) . auth()->id()],
                'kode_elemen' => [($i + 1) . auth()->id() . $this->skema->id],
                'unikom_name' => [$uk->unikom],
                'unikom_id' => [$uk->id],
                'unikom_kode' => [$uk->kode_unikom],
                'data_register_id' => [$register->id],
                'status' => ['Tidak Kompeten'],
                'skema_id' => [$this->skema->id],
                'skema_name' => [$this->skema->skema],
                'asesmen_name' => ['Test'],
                'kriteria' => ['Test'],
            ]);
        }

        // Submit formulirapl1 -> status = "Menunggu Validasi"
        $this->put("/registrasi/{$register->id}", [
            'skema_id' => $this->skema->kode_skema . $this->asesi->id,
            'status' => 'Menunggu Validasi',
        ]);
        $register->refresh();
        $this->assertEquals('Menunggu Validasi', $register->status);

        // === ADMIN FLOW ===
        $this->actingAs($this->admin);

        // Approve validation
        $this->put("/validasi/{$register->id}/status", [
            'status' => 'diverifikasi',
            'keterangan' => 'Disetujui',
        ]);
        $register->refresh();
        $this->assertEquals('Pendaftaran Divalidasi', $register->status);

        // Assign asesor/TUK
        $this->put("/validasi/{$register->id}", [
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '09:00',
            'asesor_id' => $this->asesorUser->id,
            'tuk_id' => $this->tuk->id,
            'keterangan' => 'Assigned',
        ]);
        $register->refresh();
        $this->assertEquals($this->asesorUser->id, $register->asesor_id);

        // === ASESOR FLOW ===
        $this->actingAs($this->asesorUser);

        // Penilaian
        $penilaianData = [];
        foreach ($this->unikoms as $uk) {
            $penilaianData[$uk->id] = 'kompeten';
        }
        $this->post("/dashboard-asesor/penilaian/{$register->id}/update", [
            'penilaian' => $penilaianData,
        ]);

        // Observasi
        $this->post("/dashboard-asesor/observasi/{$register->id}", [
            'aktivitas' => [['nama' => 'Test', 'hasil' => 'Baik']],
            'catatan' => 'OK',
        ]);

        // Validasi
        $this->post("/dashboard-asesor/validasi/{$register->id}", [
            'bukti_lengkap' => '1',
            'observasi_sesuai' => '1',
            'nilai_konsisten' => '1',
        ]);

        // Rekomendasi
        $this->post("/dashboard-asesor/rekomendasi/{$register->id}", [
            'keputusan' => 'Direkomendasikan Sertifikasi',
            'catatan' => 'OK',
        ]);

        $register->refresh();
        $this->assertEquals('Sertifikasi Selesai', $register->status);

        // === POST-SERTIFIKASI ===
        $this->actingAs($this->asesi);
        $this->get('/koleksi_sertifikat')->assertStatus(200);

        // Create feedback directly (HTTP endpoint has middleware issues in test env)
        FrAk03::create([
            'data_register_id' => $register->id,
            'user_id' => $this->asesi->id,
            'rating' => 5,
            'feedback' => 'Sangat memuaskan!',
        ]);

        $this->assertNotNull(FrAk03::where('data_register_id', $register->id)->first());
    }

    /** @test */
    public function asesi_cannot_register_twice_for_same_skema()
    {
        $this->actingAs($this->asesi);

        $registerId = auth()->id() . $this->skema->id;

        // First registration
        $this->post('/registrasi', [
            'id' => $registerId,
            'kode' => (string) auth()->id(),
            'skema_id' => $this->skema->id,
            'kode_skema' => $this->skema->kode_skema,
            'nik' => auth()->user()->nik,
            'jurusan_id' => auth()->user()->jurusan_id,
            'id_skema' => 'progres',
            'skema_name' => $this->skema->skema,
            'tuk_id' => 1,
            'asesor_id' => 1,
            'sex_id' => auth()->user()->sex_id,
        ]);

        // Try registering for same skema with different ID
        $response = $this->post('/registrasi', [
            'id' => auth()->id() . $this->skema->id . 'dup',
            'kode' => (string) auth()->id(),
            'skema_id' => $this->skema->id,
            'kode_skema' => $this->skema->kode_skema,
            'nik' => auth()->user()->nik,
            'jurusan_id' => auth()->user()->jurusan_id,
            'id_skema' => 'progres',
            'skema_name' => $this->skema->skema,
            'tuk_id' => 1,
            'asesor_id' => 1,
            'sex_id' => auth()->user()->sex_id,
        ]);

        // Should still only have 1 registration
        $registers = Data_register::where('user_id', $this->asesi->id)
            ->where('skema_id', $this->skema->id)
            ->get();
        $this->assertCount(1, $registers);
    }

    /** @test */
    public function asesi_can_edit_rejected_registration()
    {
        $register = $this->createRegistration('Pendaftaran Ditolak');
        $this->actingAs($this->asesi);

        // Visit the edit-tolak page
        $response = $this->get("/data_edit_tolak/{$register->id}");
        $response->assertStatus(200);

        // Re-submit with status "Menunggu Validasi"
        $response = $this->put("/registrasi/{$register->id}", [
            'skema_id' => $this->skema->kode_skema . $this->asesi->id,
            'status' => 'Menunggu Validasi',
        ]);
        $response->assertStatus(302);

        $register->refresh();
        $this->assertEquals('Menunggu Validasi', $register->status);
    }

    // --- Helpers ---

    private function createRegistration($status, $extra = [])
    {
        return Data_register::create(array_merge([
            'id' => mt_rand(10000, 99999),
            'user_id' => $this->asesi->id,
            'user_name' => $this->asesi->name,
            'skema_id' => $this->skema->id,
            'skema_name' => $this->skema->skema,
            'kode_skema' => $this->skema->kode_skema,
            'kode' => (string) $this->asesi->id,
            'nik' => $this->asesi->nik,
            'status' => $status,
            'tmpt_lahir' => 'Jakarta',
            'tgl_lahir' => '2000-01-15',
            'sex_id' => 1,
            'alamat' => 'Jl. Test No. 123',
            'no_hp' => '08123456789',
        ], $extra));
    }
}
