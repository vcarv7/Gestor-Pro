@props([])

@php
$user = Auth::user();
$name = $user->name ?? 'Admin';
$initials = '';
foreach (explode(' ', $name) as $part) {
$initials .= strtoupper(mb_substr($part, 0, 1));
if (strlen($initials) >= 2) break;
}
@endphp

<header class="sticky top-0 z-10 bg-surface-container-lowest border-b border-outline-variant px-lg py-md flex items-center gap-md">

    {{-- Search --}}
    <div class="flex-1 max-w-2xl relative"
        x-data="{
            query: '',
            results: [],
            open: false,
            isLoading: false,
            timer: null,
            searchUrl: '{{ route('search') }}',
            search() {
                clearTimeout(this.timer);
                if (this.query.length < 2) {
                    this.results = [];
                    this.isLoading = false;
                    return;
                }
                this.isLoading = true;
                this.timer = setTimeout(async () => {
                    try {
                        const res = await fetch(this.searchUrl + '?q=' + encodeURIComponent(this.query));
                        const data = await res.json();
                        this.results = data.results || [];
                    } catch (e) {
                        this.results = [];
                    } finally {
                        this.isLoading = false;
                    }
                }, 300);
            },
            badgeClasses(variant) {
                return {
                    'primary': 'bg-primary-container text-on-primary-container',
                    'secondary': 'bg-secondary-container text-on-secondary-container',
                    'tertiary': 'bg-tertiary-container text-on-tertiary-container',
                }[variant] || 'bg-surface-container text-on-surface';
            }
        }"
        @click.outside="open = false">
        <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px] z-10">search</span>
        <input type="text" placeholder="Buscar proyectos, clientes o tareas..."
            x-model="query"
            @input="search(); open = true"
            @focus="open = true"
            @keydown.escape="open = false"
            autocomplete="off"
            class="w-full pl-[44px] pr-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary focus:bg-surface-container-lowest transition-all outline-none" />

        {{-- Dropdown de resultados --}}
        <div x-show="open && (results.length > 0 || isLoading || query.length >= 2)"
            x-cloak
            @click.stop
            class="absolute left-0 right-0 top-full mt-sm bg-surface-container-lowest border border-outline-variant rounded-xl shadow-lg overflow-hidden z-50 max-h-[480px] overflow-y-auto">

            {{-- Loading --}}
            <div x-show="isLoading" class="p-md text-center">
                <span class="font-body-sm text-body-sm text-on-surface-variant">Buscando...</span>
            </div>

            {{-- Sin resultados --}}
            <div x-show="!isLoading && query.length >= 2 && results.length === 0"
                class="p-md text-center">
                <span class="material-symbols-outlined text-[32px] text-outline">search_off</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-sm">No se encontraron resultados</p>
            </div>

            {{-- Resultados --}}
            <template x-for="r in results" :key="r.type + '-' + r.id">
                <a :href="r.url"
                    class="flex items-center gap-md px-md py-sm hover:bg-surface-container transition-colors border-b border-outline-variant/50 last:border-b-0">
                    <div class="shrink-0 w-10 h-10 rounded-lg flex items-center justify-center"
                        :class="r.badge_variant === 'primary' ? 'bg-primary-container text-on-primary-container' : (r.badge_variant === 'secondary' ? 'bg-secondary-container text-on-secondary-container' : 'bg-tertiary-container text-on-tertiary-container')">
                        <span class="material-symbols-outlined text-[20px]" x-text="r.icon"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-label-md text-label-md text-on-surface truncate" x-text="r.title"></p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant truncate" x-text="r.subtitle"></p>
                    </div>
                    <span class="shrink-0 px-sm py-xs rounded-full font-label-sm text-label-sm"
                        :class="badgeClasses(r.badge_variant)"
                        x-text="r.type_label"></span>
                </a>
            </template>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-xs">

        {{-- Notificaciones Dropdown --}}
        <div class="relative"
            x-data="{
            open: false,
            unreadCount: 0,
            recent: [],
            async fetchNotifications() {
                try {
                    const res = await fetch('{{ route('notifications.recent') }}');
                    const data = await res.json();
                    this.unreadCount = data.unread_count;
                    this.recent = data.recent;
                } catch {}
            },
            toggle() {
                if (!this.open) this.fetchNotifications();
                this.open = !this.open;
            },
            markRead(id) {
                fetch('{{ url('/notificaciones') }}/' + id + '/read', {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
                }).then(() => {
                    this.fetchNotifications();
                });
            }
        }"
            @click.outside="open = false">
            <button @click="toggle()"
                class="relative p-sm rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[22px]">notifications</span>
                <span x-show="unreadCount > 0"
                    x-text="unreadCount"
                    class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] flex items-center justify-center rounded-full bg-error text-[10px] font-bold text-on-error px-[4px]"></span>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" x-cloak
                class="absolute right-0 top-full mt-sm w-80 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-lg overflow-hidden z-50">
                <div class="p-md border-b border-outline-variant flex items-center justify-between">
                    <span class="font-label-md text-label-md text-on-surface font-semibold">Notificaciones</span>
                    <a href="{{ route('notifications.index') }}"
                        class="font-label-sm text-label-sm text-primary hover:text-on-primary-container">Ver todas</a>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    <template x-if="recent.length === 0">
                        <div class="p-md text-center">
                            <span class="material-symbols-outlined text-[32px] text-outline">notifications_off</span>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-sm">No hay notificaciones</p>
                        </div>
                    </template>
                    <template x-for="n in recent" :key="n.id">
                        <div class="flex items-start gap-sm px-md py-sm hover:bg-surface-container transition-colors border-b border-outline-variant/50 cursor-pointer"
                            :class="n.read_at ? '' : 'bg-primary-container/20'"
                            @click="markRead(n.id)">
                            <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                                :class="n.read_at ? 'bg-surface-container text-on-surface-variant' : 'bg-primary text-on-primary'">
                                <span class="material-symbols-outlined text-[16px]">notifications</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-label-sm text-label-sm text-on-surface" x-text="n.title"></p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant truncate" x-text="n.message"></p>
                                <p class="font-body-xs text-body-xs text-outline mt-[2px]" x-text="timeAgo(n.created_at)"></p>
                            </div>
                            <template x-if="!n.read_at">
                                <span class="w-2 h-2 rounded-full bg-error shrink-0 mt-sm"></span>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Mensajes --}}
        <button class="p-sm rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[22px]">chat_bubble</span>
        </button>

        {{-- User info (avatar + name + role) --}}
        <div class="flex items-center gap-sm ml-md pl-md border-l border-outline-variant">
            <div class="text-right hidden sm:block">
                <div class="font-label-md text-label-md text-on-surface leading-tight">{{ $name }}</div>
                <div class="font-label-sm text-label-sm text-on-surface-variant">Plan Pro</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-md text-label-md">
                {{ $initials ?: 'AD' }}
            </div>
        </div>

    </div>

</header>

@push('scripts')
<script>
    function timeAgo(dateStr) {
        if (!dateStr) return '';
        const date = new Date(dateStr.replace(' ', 'T'));
        if (isNaN(date.getTime())) return '';

        const now = new Date();
        const diff = Math.floor((now - date) / 1000);

        if (diff < 5) return 'ahora';
        if (diff < 0) return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
        if (diff < 60) return diff + ' s';
        if (diff < 3600) return Math.floor(diff / 60) + ' min';
        if (diff < 86400) return Math.floor(diff / 3600) + ' h';
        if (diff < 604800) return Math.floor(diff / 86400) + ' d';
        return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
    }
</script>
@endpush
