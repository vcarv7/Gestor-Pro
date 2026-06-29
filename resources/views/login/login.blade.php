<!DOCTYPE html>

<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | Mi Gestor Pro</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-fixed": "#d5e3fd",
                    "primary-fixed": "#dae2fd",
                    "on-tertiary-fixed": "#0b1c30",
                    "tertiary": "#000000",
                    "surface-dim": "#d8dadc",
                    "on-secondary": "#ffffff",
                    "surface-tint": "#565e74",
                    "on-secondary-fixed": "#0d1c2f",
                    "surface-container": "#eceef0",
                    "surface-variant": "#e0e3e5",
                    "primary-container": "#131b2e",
                    "on-tertiary-container": "#75859d",
                    "on-tertiary-fixed-variant": "#38485d",
                    "inverse-on-surface": "#eff1f3",
                    "primary-fixed-dim": "#bec6e0",
                    "on-primary-fixed-variant": "#3f465c",
                    "on-primary": "#ffffff",
                    "on-error-container": "#93000a",
                    "surface-container-high": "#e6e8ea",
                    "outline": "#76777d",
                    "on-secondary-container": "#57657b",
                    "on-secondary-fixed-variant": "#3a485c",
                    "on-error": "#ffffff",
                    "secondary-container": "#d5e3fd",
                    "error": "#ba1a1a",
                    "secondary-fixed-dim": "#b9c7e0",
                    "surface-container-lowest": "#ffffff",
                    "primary": "#000000",
                    "surface-bright": "#f7f9fb",
                    "surface-container-low": "#f2f4f6",
                    "on-background": "#191c1e",
                    "outline-variant": "#c6c6cd",
                    "tertiary-fixed-dim": "#b7c8e1",
                    "on-surface-variant": "#45464d",
                    "inverse-surface": "#2d3133",
                    "background": "#f7f9fb",
                    "secondary": "#515f74",
                    "error-container": "#ffdad6",
                    "surface": "#f7f9fb",
                    "tertiary-fixed": "#d3e4fe",
                    "inverse-primary": "#bec6e0",
                    "tertiary-container": "#0b1c30",
                    "on-tertiary": "#ffffff",
                    "on-surface": "#191c1e",
                    "on-primary-fixed": "#131b2e",
                    "on-primary-container": "#7c839b",
                    "surface-container-highest": "#e0e3e5"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "spacing": {
                    "xl": "32px",
                    "gutter": "16px",
                    "container-margin": "24px",
                    "base": "8px",
                    "xs": "4px",
                    "sm": "8px",
                    "md": "16px",
                    "lg": "24px"
            },
            "fontFamily": {
                    "label-md": ["Inter"],
                    "body-md": ["Inter"],
                    "body-lg": ["Inter"],
                    "body-sm": ["Inter"],
                    "display-lg": ["Inter"],
                    "headline-md": ["Inter"],
                    "headline-sm": ["Inter"],
                    "label-sm": ["Inter"],
                    "headline-lg-mobile": ["Inter"],
                    "headline-lg": ["Inter"]
            },
            "fontSize": {
                    "label-md": ["14px", {"lineHeight": "1", "letterSpacing": "0.01em", "fontWeight": "500"}],
                    "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "body-sm": ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
                    "display-lg": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-md": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
                    "headline-sm": ["20px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "label-sm": ["12px", {"lineHeight": "1", "fontWeight": "600"}],
                    "headline-lg-mobile": ["24px", {"lineHeight": "1.2", "fontWeight": "600"}],
                    "headline-lg": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600"}]
            }
          },
        },
      }
    </script>
<style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      
      body {
        font-family: 'Inter', sans-serif;
        background-color: #f7f9fb; /* surface */
      }

      /* Tonal Layering effect for background */
      .bg-subtle-pattern {
        background-image: radial-gradient(circle at 2px 2px, #e2e8f0 1px, transparent 0);
        background-size: 32px 32px;
      }

      .login-card {
        background-color: #ffffff; /* Surface 1 */
        border: 1px solid #e2e8f0; /* outline-variant style */
      }

      .focus-ring:focus {
        outline: none;
        box-shadow: 0 0 0 2px #0f172a; /* Primary Deep Blue focus */
      }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-md bg-subtle-pattern">
<!-- Login Container -->
<main class="w-full max-w-[440px] animate-fade-in">
<!-- Identity Branding (Center Top) -->
<div class="flex flex-col items-center mb-xl text-center">
<img alt="Mi Gestor Pro Logo" class="w-20 h-20 mb-md object-contain" src="https://lh3.googleusercontent.com/aida/AP1WRLuXwRZEyWbmcLJdKqiUyGiUHUGeX7oUroccU52w8kl4_7Bpf-Qlrx37Ug0z9-BL5iHXhqnuFEG4xIvJaBCxU8GovhAx6UzpIVHiB5EUd6rvFk8XOTuPISaHYRZ_ZrW1fsbfRvlrwHKZgJlINyZnjYoiBXUVOY0W7vfRPDz3M5x4ETGiUSOFOA_CFnWd6eNJOQcFPQBeB40XttOdwxWPJIYuWs0dECTcNzW1qgo0f4E-1Im4KH51dABulg"/>
<h1 class="font-headline-md text-headline-md text-primary mb-xs">Mi Gestor Pro</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Freelance Workspace</p>
</div>
<!-- Login Card -->
<div class="login-card rounded-xl p-lg md:p-xl shadow-sm">
<div class="mb-lg">
<h2 class="font-headline-sm text-headline-sm text-on-surface">Iniciar sesión</h2>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Ingresa tus credenciales para acceder a tu panel de control.</p>
</div>
<form action="#" class="space-y-lg" method="POST">
<!-- Email Field -->
<div>
<label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="email">Correo Electrónico</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline">mail</span>
<input class="w-full pl-[48px] pr-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-outline-variant" id="email" name="email" placeholder="tu@email.com" required="" type="email"/>
</div>
</div>
<!-- Password Field -->
<div>
<label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="password">Contraseña</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline">lock</span>
<input class="w-full pl-[48px] pr-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-outline-variant" id="password" name="password" placeholder="••••••••" required="" type="password"/>
<button class="absolute right-md top-1/2 -translate-y-1/2 text-outline-variant hover:text-outline transition-colors" type="button">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
</div>
</div>
<!-- Remember & Forgot -->
<div class="flex items-center justify-between">
<label class="flex items-center cursor-pointer group">
<input class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary transition-all" type="checkbox"/>
<span class="ml-sm font-label-md text-label-md text-on-surface-variant group-hover:text-on-surface transition-colors">Recordarme</span>
</label>
<a class="font-label-md text-label-md text-secondary hover:text-primary transition-colors hover:underline decoration-2 underline-offset-4" href="#">
                        ¿Olvidaste tu contraseña?
                    </a>
</div>
<!-- Login Button -->
<button class="w-full bg-[#0F172A] hover:bg-black text-white font-label-md text-label-md py-md px-lg rounded-xl flex items-center justify-center gap-sm transition-all duration-200 active:scale-[0.98] shadow-md" type="submit">
                    Acceder
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</button>
</form>
<!-- Secondary Action -->
<div class="mt-xl pt-lg border-t border-outline-variant text-center">
<p class="font-body-sm text-body-sm text-on-surface-variant">
                    ¿No tienes una cuenta? 
                    <a class="font-label-md text-label-md text-primary font-bold hover:underline decoration-2 underline-offset-4 ml-xs" href="#">Regístrate gratis</a>
</p>
</div>
</div>
<!-- Footer Help -->
<footer class="mt-lg flex justify-center gap-lg">
<a class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors flex items-center gap-xs" href="#">
<span class="material-symbols-outlined text-[16px]">help</span>
                Ayuda
            </a>
<a class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors flex items-center gap-xs" href="#">
<span class="material-symbols-outlined text-[16px]">shield</span>
                Privacidad
            </a>
<a class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors flex items-center gap-xs" href="#">
<span class="material-symbols-outlined text-[16px]">language</span>
                Español
            </a>
</footer>
</main>
<script>
        // Micro-interaction for the password visibility toggle
        const toggleBtn = document.querySelector('button[type="button"]');
        const passInput = document.getElementById('password');
        
        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', () => {
                const isPass = passInput.type === 'password';
                passInput.type = isPass ? 'text' : 'password';
                toggleBtn.querySelector('.material-symbols-outlined').textContent = isPass ? 'visibility_off' : 'visibility';
            });
        }

        // Simple button loading state simulation
        const loginForm = document.querySelector('form');
        const loginBtn = loginForm.querySelector('button[type="submit"]');

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const originalText = loginBtn.innerHTML;
            loginBtn.disabled = true;
            loginBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Verificando...
            `;
            
            // Artificial delay to show state
            setTimeout(() => {
                loginBtn.innerHTML = originalText;
                loginBtn.disabled = false;
                alert('Funcionalidad de inicio de sesión no implementada en este prototipo visual.');
            }, 1500);
        });
    </script>
</body></html>