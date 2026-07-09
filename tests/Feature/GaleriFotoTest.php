<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Group_galeri;
use App\Models\Galeri_foto;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GaleriFotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_multiple_photos_to_album()
    {
        Storage::fake('public');

        // Create admin role and user
        Role::create(['name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Create Group Galeri (Album)
        $album = Group_galeri::create([
            'galeri' => 'Album Liburan',
        ]);

        // Create dummy files
        $file1 = UploadedFile::fake()->image('liburan1.jpg');
        $file2 = UploadedFile::fake()->image('liburan2.png');

        // Act: POST to upload_foto
        $response = $this->actingAs($admin)
            ->from(route('galeri.show', \Illuminate\Support\Facades\Crypt::encryptString($album->id)))
            ->post(route('foto.store'), [
                'group_galeri_id' => $album->id,
                'image' => [
                    $file1,
                    $file2,
                ]
            ]);

        // Assert: Redirected back
        $redirectUrl = $response->headers->get('Location');
        $this->assertNotNull($redirectUrl);
        
        $parts = explode('/galeri/', $redirectUrl);
        $encryptedId = end($parts);
        $decryptedId = \Illuminate\Support\Facades\Crypt::decryptString($encryptedId);
        $this->assertEquals($album->id, $decryptedId);

        $response->assertSessionHas('success', '2 gambar berhasil diupload');

        // Assert: Database records created
        $this->assertDatabaseHas('galeri_fotos', [
            'group_galeri_id' => $album->id,
        ]);

        // Check exact count
        $this->assertEquals(2, Galeri_foto::where('group_galeri_id', $album->id)->count());
    }
}
