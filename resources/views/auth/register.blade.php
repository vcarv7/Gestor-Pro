<x-guest-layout>
    <x-slot:title>Crear cuenta</x-slot:title>

    <div class="auth-container bg-subtle-pattern">
        <main class="w-full max-w-[440px] animate-fade-in">
            <!-- Identity Branding -->
            <div class="flex flex-col items-center mb-xl text-center">
                <x-logo class="w-20 h-20 mb-md" />
                <h1 class="font-display-lg text-display-lg text-primary mb-xs">Mi Gestor Pro</h1>
            </div>

            <!-- Register Card -->
            <div class="login-card rounded-xl p-lg md:p-xl shadow-sm">
                <div class="mb-lg">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Crear cuenta</h2>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Empezá a gestionar tus proyectos en minutos.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" data-loading class="space-y-lg">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <x-input-label for="name" value="Nombre" class="font-label-md text-label-md text-on-surface-variant mb-xs" />
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none">person</span>
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                required
                                autofocus
                                autocomplete="name"
                                :value="old('name')"
                                placeholder="Tu nombre"
                                class="w-full pl-[48px] pr-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-outline-variant" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Field -->
                    <div>
                        <x-input-label for="email" value="Correo Electrónico" class="font-label-md text-label-md text-on-surface-variant mb-xs" />
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none">mail</span>
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autocomplete="username"
                                :value="old('email')"
                                placeholder="tu@email.com"
                                class="w-full pl-[48px] pr-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-outline-variant" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <x-input-label for="password" value="Contraseña" class="font-label-md text-label-md text-on-surface-variant mb-xs" />
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none">lock</span>
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full pl-[48px] pr-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-outline-variant" />
                            <button type="button" data-toggle-password
                                class="absolute right-md top-1/2 -translate-y-1/2 text-outline-variant hover:text-outline transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <x-input-label for="password_confirmation" value="Confirmar contraseña" class="font-label-md text-label-md text-on-surface-variant mb-xs" />
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none">lock_reset</span>
                            <x-text-input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full pl-[48px] pr-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-outline-variant" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Register Button -->
                    <x-primary-button class="w-full justify-center bg-[#0F172A] hover:bg-black text-white font-label-md text-label-md py-md px-lg rounded-xl gap-sm transition-all duration-200 active:scale-[0.98] shadow-md">
                        Crear cuenta
                        <span class="material-symbols-outlined text-[18px]">person_add</span>
                    </x-primary-button>
                </form>

                <!-- Login Link -->
                <p class="text-center font-body-sm text-body-sm text-on-surface-variant mt-lg">
                    ¿Ya tenés cuenta?
                    <a href="{{ route('login') }}" class="font-label-md text-label-md text-secondary hover:text-primary hover:underline decoration-2 underline-offset-4 transition-colors">
                        Iniciá sesión
                    </a>
                </p>
            </div>

            <!-- Footer Help -->
            <footer class="mt-lg flex justify-center gap-lg">
                <a href="#" class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[16px]">help</span>
                    Ayuda
                </a>
                <a href="#" class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[16px]">shield</span>
                    Privacidad
                </a>
                <a href="#" class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[16px]">language</span>
                    Español
                </a>
            </footer>
        </main>
    </div>
</x-guest-layout>
