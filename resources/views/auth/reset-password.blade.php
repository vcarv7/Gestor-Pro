<x-guest-layout>
    <x-slot:title>Restablecer contraseña</x-slot:title>

    <div class="auth-container glass-background text-on-surface">
        <main class="w-full max-w-[420px]">
            <!-- Branding Area -->
            <div class="mb-xl text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-container rounded-xl mb-md">
                    <span class="material-symbols-outlined text-on-primary text-3xl" style="font-variation-settings: 'FILL' 1;">lock</span>
                </div>
                <h1 class="font-headline-md text-headline-md text-primary mb-xs">Mi Gestor Pro</h1>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Freelance Workspace</p>
            </div>

            <!-- Reset Card -->
            <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl login-card">
                <div class="mb-lg">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-xs">Restablecer Contraseña</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Elige una nueva contraseña para acceder a tu cuenta.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" data-loading class="space-y-lg">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Field -->
                    <div class="space-y-xs">
                        <label for="email" class="font-label-md text-label-md text-on-surface-variant block">Correo Electrónico</label>
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            :value="old('email', $request->email)"
                            readonly
                            class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none font-body-md text-body-md bg-surface-container-low text-on-surface-variant cursor-not-allowed" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-xs">
                        <label for="password" class="font-label-md text-label-md text-on-surface-variant block">Nueva contraseña</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none">lock</span>
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full pl-[48px] pr-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none font-body-md text-body-md bg-white" />
                            <button type="button" data-toggle-password
                                class="absolute right-md top-1/2 -translate-y-1/2 text-outline-variant hover:text-outline transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-xs">
                        <label for="password_confirmation" class="font-label-md text-label-md text-on-surface-variant block">Confirmar contraseña</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none">lock_reset</span>
                            <x-text-input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full pl-[48px] pr-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none font-body-md text-body-md bg-white" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <x-primary-button class="w-full justify-center bg-primary hover:bg-opacity-90 text-on-primary font-label-md text-label-md py-sm rounded-lg transition-all duration-200 gap-sm h-[48px]">
                        <span>Restablecer contraseña</span>
                        <span class="material-symbols-outlined text-[20px]">check</span>
                    </x-primary-button>
                </form>

                <!-- Divider -->
                <div class="relative my-xl">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-outline-variant"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-surface-container-lowest px-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">O</span>
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-primary hover:underline transition-all">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        Volver al inicio de sesión
                    </a>
                </div>
            </div>

            <!-- Support Footer -->
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
