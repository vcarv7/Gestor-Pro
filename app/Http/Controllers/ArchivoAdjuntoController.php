<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchivoRequest;
use App\Models\Actividad;
use App\Models\Archivo;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoAdjuntoController extends Controller
{
    private function disk(): string
    {
        return config('filesystems.default');
    }

    public function store(StoreArchivoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('view', $proyecto);

        $file = $request->file('archivo');
        $uuid = (string) Str::uuid();
        $extension = $file->getClientOriginalExtension();
        $nombreStorage = "{$uuid}.{$extension}";

        $file->storeAs("proyectos/{$proyecto->id}", $nombreStorage, $this->disk());

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

    public function download(Archivo $archivo)
    {
        $this->authorize('download', $archivo);

        $path = "proyectos/{$archivo->proyecto_id}/{$archivo->nombre_storage}";

        if (! Storage::disk($this->disk())->exists($path)) {
            abort(404, 'El archivo ya no existe en el servidor.');
        }

        return Storage::disk($this->disk())->download($path, $archivo->nombre_original);
    }

    public function destroy(Archivo $archivo): RedirectResponse
    {
        $this->authorize('delete', $archivo);

        $path = "proyectos/{$archivo->proyecto_id}/{$archivo->nombre_storage}";
        Storage::disk($this->disk())->delete($path);

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

    public function restore($id): RedirectResponse
    {
        $archivo = Archivo::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $archivo);

        $archivo->restore();

        return redirect()->route('proyectos.show', $archivo->proyecto_id)
            ->with('status', 'Archivo restaurado.');
    }

    public function forceDelete($id): RedirectResponse
    {
        $archivo = Archivo::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $archivo);

        $path = "proyectos/{$archivo->proyecto_id}/{$archivo->nombre_storage}";
        Storage::disk($this->disk())->delete($path);

        $archivo->forceDelete();

        return redirect()->route('proyectos.show', $archivo->proyecto_id)
            ->with('status', 'Archivo eliminado permanentemente.');
    }
}
