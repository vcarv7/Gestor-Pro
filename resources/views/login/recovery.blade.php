<!DOCTYPE html>

<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Recuperar Contraseña - Mi Gestor Pro</title>
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
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .login-card {
            box-shadow: 0px 4px 20px rgba(15, 23, 42, 0.08);
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        /* Glassmorphism subtle overlay */
        .glass-background {
            background: radial-gradient(circle at 50% 50%, #eff6ff 0%, #f7f9fb 100%);
        }
    </style>
</head>
<body class="glass-background text-on-surface">
<div class="auth-container">
<!-- Main Form Shell -->
<main class="w-full max-w-[420px]">
<!-- Branding Area -->
<div class="mb-xl text-center">
<div class="inline-flex items-center justify-center w-16 h-16 bg-primary-container rounded-xl mb-md">
<span class="material-symbols-outlined text-on-primary text-3xl" style="font-variation-settings: 'FILL' 1;">lock_reset</span>
</div>
<h1 class="font-headline-md text-headline-md text-primary mb-xs">Mi Gestor Pro</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant">Freelance Workspace</p>
</div>
<!-- Recovery Card -->
<div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl login-card">
<div class="mb-lg">
<h2 class="font-headline-sm text-headline-sm text-on-surface mb-xs">Recuperar Contraseña</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Ingresa tu email para recibir un enlace de restablecimiento</p>
</div>
<form class="space-y-lg" id="recoveryForm">
<!-- Email Field -->
<div class="space-y-xs">
<label class="font-label-md text-label-md text-on-surface-variant block" for="email">Correo Electrónico</label>
<div class="relative">
<input class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none font-body-md text-body-md bg-white" id="email" name="email" placeholder="tu@email.com" required="" type="email"/>
</div>
</div>
<!-- Submit Button -->
<button class="w-full bg-primary hover:bg-opacity-90 text-on-primary font-label-md text-label-md py-sm rounded-lg transition-all duration-200 flex items-center justify-center gap-sm h-[48px]" type="submit">
<span>Enviar enlace</span>
<span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</button>
</form>
<!-- Feedback Message (Hidden by default) -->
<div class="hidden mt-lg p-md bg-secondary-container rounded-lg border border-outline-variant" id="successMessage">
<div class="flex gap-md items-start">
<span class="material-symbols-outlined text-on-secondary-container" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<div>
<p class="font-label-md text-label-md text-on-secondary-container mb-xs">Enlace enviado</p>
<p class="font-body-sm text-body-sm text-on-secondary-container">Hemos enviado instrucciones a tu correo para restablecer tu cuenta.</p>
</div>
</div>
</div>
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
<a class="inline-flex items-center gap-xs font-label-md text-label-md text-primary hover:underline transition-all" href="/login">
<span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        Volver al inicio de sesión
                    </a>
</div>
</div>
<!-- Support Footer -->
<footer class="mt-xl text-center space-y-sm">
<p class="font-body-sm text-body-sm text-on-surface-variant">
                    ¿Necesitas más ayuda? <a class="text-primary font-label-md hover:underline" href="#">Contactar soporte</a>
</p>
<div class="flex justify-center gap-md opacity-60">
<span class="font-label-sm text-label-sm">Privacy</span>
<span class="font-label-sm text-label-sm">Terms</span>
<span class="font-label-sm text-label-sm">Security</span>
</div>
</footer>
</main>
</div>
<!-- Micro-interactions Script -->
<script>
        document.getElementById('recoveryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const emailInput = document.getElementById('email');
            
            // Loading state
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span>';
            btn.disabled = true;
            emailInput.disabled = true;
            emailInput.classList.add('opacity-50');

            // Simulate API call
            setTimeout(() => {
                btn.classList.add('hidden');
                document.getElementById('successMessage').classList.remove('hidden');
                document.getElementById('successMessage').classList.add('animate-fade-in');
            }, 1500);
        });
    </script>
<style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out forwards;
        }
    </style>
</body></html>