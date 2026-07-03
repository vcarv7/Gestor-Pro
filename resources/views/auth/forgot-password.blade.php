<x-guest-layout>
    <x-slot:title>Recuperar contraseña</x-slot:title>

    <div class="auth-container glass-background text-on-surface">
        <main class="w-full max-w-[420px]">
            <div class="mb-xl text-center flex flex-col items-center">
                <x-logo class="w-20 h-20 mb-md" />
                <h1 class="font-display-lg text-display-lg text-primary mb-xs">Mi Gestor Pro</h1>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl login-card">
                <div class="mb-lg">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-xs">Recuperar Contraseña</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Ingresa tu email para recibir un enlace de restablecimiento</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" id="recoveryForm" class="space-y-lg">
                    @csrf

                    <div class="space-y-xs">
                        <label for="email" class="font-label-md text-label-md text-on-surface-variant block">Correo Electrónico</label>
                        <x-text-input id="email" name="email" type="email" required autofocus :value="old('email')" placeholder="tu@email.com"
                            class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none font-body-md text-body-md bg-white" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full justify-center bg-primary hover:bg-opacity-90 text-on-primary font-label-md text-label-md py-sm rounded-lg transition-all duration-200 gap-sm h-[48px]">
                        <span>Enviar enlace</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </x-primary-button>
                </form>

                @if (session('status'))
                    <div class="mt-lg p-md bg-secondary-container rounded-lg border border-outline-variant animate-fade-in">
                        <div class="flex gap-md items-start">
                            <span class="material-symbols-outlined text-on-secondary-container" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <div>
                                <p class="font-label-md text-label-md text-on-secondary-container mb-xs">Enlace enviado</p>
                                <p class="font-body-sm text-body-sm text-on-secondary-container">Hemos enviado instrucciones a tu correo para restablecer tu cuenta.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="relative my-xl">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-outline-variant"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-surface-container-lowest px-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">O</span>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-primary hover:underline transition-all">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        Volver al inicio de sesión
                    </a>
                </div>
            </div>

            <footer class="mt-xl text-center space-y-sm">
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    ¿Necesitas más ayuda? <a href="#" class="text-primary font-label-md hover:underline">Contactar soporte</a>
                </p>
                <div class="flex justify-center gap-md opacity-60">
                    <span class="font-label-sm text-label-sm">Privacy</span>
                    <span class="font-label-sm text-label-sm">Terms</span>
                    <span class="font-label-sm text-label-sm">Security</span>
                </div>
            </footer>
        </main>
    </div>
</x-guest-layout>
