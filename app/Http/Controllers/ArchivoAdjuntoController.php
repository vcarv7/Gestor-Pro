<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchivoRequest;
use App\Models\Actividad;
use App\Models\Archivo;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoAdjuntoController extends Controller
{
    public function store(StoreArchivoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeOwner($proyecto);

        $file = $request->file('archivo');
        $uuid = (string) Str::uuid();
        $extension = $file->getClientOriginalExtension();
        $nombreStorage = "{$uuid}.{$extension}";

        $file->storeAs("proyectos/{$proyecto->id}", $nombreStorage, 'r2');

        $archivo = $proyecto->archivos()->create([
            'user_id' => auth()->id(),
            'nombre_original' => $file->getClientOriginalName(),
            'nombre_storage' => $nombreStorage,
            'mime_type' => $file->getMimeType(),
            'tamano' => $file->getSize(),
            'descripcion' => $request->input('descripcion'),
        ]);

        Actividad::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'subject_type' => Archivo::class,
            'subject_id' => $archivo->id,
            'subject_label' => $archivo->nombre_original,
            'description' => null,
        ]);

        return back()->with('status', 'Archivo subido correctamente.');
    }

    public function download(Archivo $archivo): Response
    {
        if ($archivo->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para descargar este archivo.');
        }

        $path = "proyectos/{$archivo->proyecto_id}/{$archivo->nombre_storage}";

        if (! Storage::disk('r2')->exists($path)) {
            abort(404, 'El archivo ya no existe en el servidor.');
        }

        return Storage::disk('r2')->download($path, $archivo->nombre_original);
    }

    public function destroy(Archivo $archivo): RedirectResponse
    {
        if ($archivo->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar este archivo.');
        }

        $path = "proyectos/{$archivo->proyecto_id}/{$archivo->nombre_storage}";
        Storage::disk('r2')->delete($path);

        $nombreOriginal = $archivo->nombre_original;
        $archivo->delete();

        Actividad::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'subject_type' => Archivo::class,
            'subject_id' => $archivo->id,
            'subject_label' => $nombreOriginal,
            'description' => null,
        ]);

        return back()->with('status', 'Archivo eliminado.');
    }

    private function authorizeOwner(Proyecto $proyecto): void
    {
        if ($proyecto->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este proyecto.');
        }
    }
}
