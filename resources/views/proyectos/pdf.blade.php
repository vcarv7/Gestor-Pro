<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyecto: {{ $proyecto->titulo }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1a1a1a; font-size: 11pt; margin: 0; padding: 0; }
        .header { border-bottom: 3px solid #0F172A; padding: 16px 24px; }
        .header h1 { color: #0F172A; font-size: 22pt; margin: 0 0 4px; }
        .header .meta { color: #76777d; font-size: 9pt; margin: 0; }
        .body { padding: 24px; }
        h2 { color: #0F172A; font-size: 14pt; margin: 20px 0 10px; border-bottom: 2px solid #0F172A; padding-bottom: 4px; }
        .info-grid { margin: 8px 0 16px; }
        .info-row { padding: 4px 0; }
        .info-label { color: #76777d; display: inline-block; width: 140px; font-size: 10pt; }
        .info-value { font-weight: 600; color: #1a1a1a; }
        .info-value.empty { color: #999; font-style: italic; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { padding: 8px 10px; text-align: left; border-bottom: 1px solid #e0e3e5; font-size: 10pt; }
        th { background: #f2f4f6; color: #0F172A; font-weight: 600; font-size: 10pt; text-transform: uppercase; letter-spacing: 0.05em; }
        tr.row-completada { color: #999; }
        tr.row-completada td .tarea-nombre { text-decoration: line-through; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 9pt; font-weight: 600; }
        .badge-completada { background: #d5e3fd; color: #0d1c2f; }
        .badge-pendiente { background: #ffdad6; color: #93000a; }
        .badge-alta { background: #ffdad6; color: #93000a; }
        .badge-media { background: #d5e3fd; color: #0d1c2f; }
        .badge-baja { background: #eceef0; color: #45464d; }
        .empty-state { color: #999; font-style: italic; padding: 12px 0; }
        .footer { margin-top: 32px; padding-top: 12px; border-top: 1px solid #e0e3e5; color: #999; font-size: 8pt; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $proyecto->titulo }}</h1>
        <p class="meta">Reporte generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }}</p>
    </div>

    <div class="body">
        <h2>Información del Cliente</h2>
        @if ($proyecto->cliente)
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Nombre:</span>
                    <span class="info-value">{{ $proyecto->cliente->nombre }}</span>
                </div>
                @if ($proyecto->cliente->email)
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $proyecto->cliente->email }}</span>
                    </div>
                @endif
                @if ($proyecto->cliente->empresa)
                    <div class="info-row">
                        <span class="info-label">Empresa:</span>
                        <span class="info-value">{{ $proyecto->cliente->empresa }}</span>
                    </div>
                @endif
                @if ($proyecto->cliente->telefono)
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value">{{ $proyecto->cliente->telefono }}</span>
                    </div>
                @endif
                @if ($proyecto->cliente->notas)
                    <div class="info-row">
                        <span class="info-label">Notas:</span>
                        <span class="info-value">{{ $proyecto->cliente->notas }}</span>
                    </div>
                @endif
            </div>
        @else
            <p class="empty-state">Sin cliente asignado.</p>
        @endif

        <h2>Información del Proyecto</h2>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">Título:</span>
                <span class="info-value">{{ $proyecto->titulo }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Estado:</span>
                <span class="info-value">{{ ucfirst($proyecto->estado) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de inicio:</span>
                <span class="info-value {{ $proyecto->fecha_inicio ? '' : 'empty' }}">
                    {{ $proyecto->fecha_inicio?->format('d/m/Y') ?? '—' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de entrega:</span>
                <span class="info-value {{ $proyecto->fecha_entrega ? '' : 'empty' }}">
                    {{ $proyecto->fecha_entrega?->format('d/m/Y') ?? '—' }}
                </span>
            </div>
            @if ($proyecto->descripcion)
                <div class="info-row">
                    <span class="info-label">Descripción:</span>
                    <span class="info-value">{{ $proyecto->descripcion }}</span>
                </div>
            @endif
        </div>

        <h2>Tareas del Proyecto ({{ $proyecto->tareas->count() }})</h2>
        @if ($proyecto->tareas->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 50%">Tarea</th>
                        <th style="width: 15%">Prioridad</th>
                        <th style="width: 20%">Estado</th>
                        <th style="width: 15%">Fecha Límite</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proyecto->tareas as $tarea)
                        <tr class="{{ $tarea->completada ? 'row-completada' : '' }}">
                            <td><span class="tarea-nombre">{{ $tarea->nombre }}</span></td>
                            <td>
                                <span class="badge badge-{{ $tarea->prioridad }}">
                                    {{ $tarea->prioridadLabel() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $tarea->completada ? 'badge-completada' : 'badge-pendiente' }}">
                                    {{ $tarea->completada ? 'Completada' : 'Pendiente' }}
                                </span>
                            </td>
                            <td>
                                {{ $tarea->fecha_limite?->format('d/m/Y') ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="info-grid" style="margin-top: 16px;">
                <div class="info-row">
                    <span class="info-label">Total tareas:</span>
                    <span class="info-value">{{ $proyecto->tareas->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Completadas:</span>
                    <span class="info-value">{{ $proyecto->tareas->where('completada', true)->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pendientes:</span>
                    <span class="info-value">{{ $proyecto->tareas->where('completada', false)->count() }}</span>
                </div>
            </div>
        @else
            <p class="empty-state">Este proyecto no tiene tareas asignadas.</p>
        @endif

        <div class="footer">
            Mi Gestor Pro &middot; Reporte generado automáticamente
        </div>
    </div>
</body>
</html>
