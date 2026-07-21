<?php

namespace Tests\Feature;

use App\Models\Archivo;
use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArchivoTest extends TestCase
{
    use RefreshDatabase;

    public function test_file_can_be_uploaded(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $file = UploadedFile::fake()->create('documento.pdf', 100);

        $response = $this->actingAs($user)->post("/proyectos/{$proyecto->id}/archivos", [
            'archivo' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('archivos', [
            'proyecto_id' => $proyecto->id,
            'nombre_original' => 'documento.pdf',
        ]);
    }

    public function test_file_upload_rejects_invalid_type(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $file = UploadedFile::fake()->create('malware.exe', 100);

        $response = $this->actingAs($user)->post("/proyectos/{$proyecto->id}/archivos", [
            'archivo' => $file,
        ]);

        $response->assertSessionHasErrors('archivo');
    }

    public function test_file_upload_rejects_oversized(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $file = UploadedFile::fake()->create('big.pdf', 20480);

        $response = $this->actingAs($user)->post("/proyectos/{$proyecto->id}/archivos", [
            'archivo' => $file,
        ]);

        $response->assertSessionHasErrors('archivo');
    }

    public function test_file_can_be_downloaded(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $file = UploadedFile::fake()->create('doc.pdf', 100);
        $this->actingAs($user)->post("/proyectos/{$proyecto->id}/archivos", ['archivo' => $file]);

        $archivo = Archivo::first();

        $response = $this->actingAs($user)->get("/archivos/{$archivo->id}/descargar");

        $response->assertOk();
    }

    public function test_file_can_be_soft_deleted(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $file = UploadedFile::fake()->create('doc.pdf', 100);
        $this->actingAs($user)->post("/proyectos/{$proyecto->id}/archivos", ['archivo' => $file]);

        $archivo = Archivo::first();

        $response = $this->actingAs($user)->delete("/archivos/{$archivo->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted($archivo);
    }

    public function test_other_user_cannot_download_file(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $owner->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $owner->id, 'cliente_id' => $cliente->id]);
        $archivo = Archivo::factory()->create([
            'user_id' => $owner->id,
            'proyecto_id' => $proyecto->id,
        ]);

        $response = $this->actingAs($other)->get("/archivos/{$archivo->id}/descargar");

        $response->assertForbidden();
    }
}
