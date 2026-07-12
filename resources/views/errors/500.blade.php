<x-guest-layout>
    <x-slot:title>Error del servidor</x-slot:title>

    <div class="auth-container bg-subtle-pattern">
        <main class="w-full max-w-[440px] text-center animate-fade-in">
            <x-logo class="w-20 h-20 mb-lg mx-auto" />

            <div class="login-card rounded-xl p-lg md:p-xl shadow-sm">
                <div class="mb-lg">
                    <h1 class="font-display-lg text-display-lg text-error mb-md">500</h1>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Error del servidor</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                        Algo salió mal en nuestro servidor. Nuestro equipo ha sido notificado.
                    </p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-md">
                        Por favor intenta de nuevo en unos minutos.
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center gap-sm w-full px-lg py-md rounded-lg bg-[#0F172A] hover:bg-black text-white font-label-md text-label-md transition-all duration-200 active:scale-[0.98] shadow-md">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    Volver al inicio
                </a>
            </div>
        </main>
    </div>
</x-guest-layout>
