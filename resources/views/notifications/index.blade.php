<x-app-layout>
    <x-slot:title>Notificaciones</x-slot:title>

    <div class="space-y-lg">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-md">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Notificaciones</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                    Historial de notificaciones importantes.
                </p>
            </div>
            @if ($notifications->whereNull('read_at')->count() > 0)
                <form method="POST" action="{{ route('notifications.mark-all-as-read') }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                        <span class="material-symbols-outlined text-[18px]">done_all</span>
                        <span>Marcar todas como leídas</span>
                    </button>
                </form>
            @endif
        </div>

        {{-- Flash message --}}
        @if (session('status'))
            <div class="rounded-xl p-md bg-secondary-container border border-secondary-fixed">
                <p class="font-body-md text-body-md text-on-secondary-container">{{ session('status') }}</p>
            </div>
        @endif

        {{-- List --}}
        @forelse ($notifications as $notification)
            <div class="flex items-start gap-md p-md rounded-xl border {{ $notification->read_at ? 'border-outline-variant bg-surface-container-lowest' : 'border-primary bg-primary-container/30' }}">
                <div class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $notification->read_at ? 'bg-surface-container text-on-surface-variant' : 'bg-primary text-on-primary' }}">
                    <span class="material-symbols-outlined text-[20px]">
                        @switch($notification->type)
                            @case('password_change') lock_reset @break
                            @case('cliente_delete') person_remove @break
                            @case('proyecto_delete') folder_delete @break
                            @case('tarea_bulk_delete') task_alt @break
                            @default notifications
                        @endswitch
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-sm">
                        <div>
                            <p class="font-label-md text-label-md text-on-surface">{{ $notification->title }}</p>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">{{ $notification->message }}</p>
                        </div>
                        @unless ($notification->read_at)
                            <form method="POST" action="{{ route('notifications.mark-as-read', $notification) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-primary hover:text-on-primary-container font-label-sm text-label-sm">
                                    Marcar leída
                                </button>
                            </form>
                        @endunless
                    </div>
                    <p class="font-body-sm text-body-sm text-outline mt-xs">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-xl">
                <span class="material-symbols-outlined text-[48px] text-outline">notifications_off</span>
                <p class="font-body-lg text-body-lg text-on-surface-variant mt-md">No tienes notificaciones.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <x-pagination :paginator="$notifications" />
    </div>
</x-app-layout>
