<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-secondary-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Lexend', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
                        },
                        secondary: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a', 950: '#020617',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02)',
                        'card': '0 0 0 1px rgba(0, 0, 0, 0.03), 0 2px 8px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans antialiased h-full text-secondary-900">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-secondary-50 relative overflow-hidden">

        <!-- Background Decor -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-brand-100/50 blur-3xl opacity-50">
            </div>
            <div
                class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-purple-100/50 blur-3xl opacity-50">
            </div>
            <div
                class="absolute -bottom-[10%] left-[20%] w-[35%] h-[35%] rounded-full bg-teal-100/50 blur-3xl opacity-50">
            </div>
        </div>

        <div
            class="z-10 w-full sm:max-w-lg mt-6 bg-white/80 backdrop-blur-xl shadow-card rounded-2xl overflow-hidden border border-white/50">
            <!-- Header -->
            <div class="px-8 py-10 text-center border-b border-secondary-100/50">
                <a href="/" class="inline-flex items-center gap-2 group">
                    <span
                        class="font-display font-bold text-3xl tracking-tight text-secondary-900">{{ config('app.name') }}</span>
                </a>
            </div>

            <!-- Content -->
            <div class="px-10 py-10">
                {{ $slot }}
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-secondary-500 z-10">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>