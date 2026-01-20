<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ZalvlmaX') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4f46e5',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            background-image: radial-gradient(#6366f1 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative">

    <!-- Navbar Minimalis -->
    <header class="w-full py-6 px-6 md:px-12 flex items-center justify-between relative z-10">
        <a href="/" class="flex items-center gap-2 group">
            <div class="text-indigo-600">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
               </svg>
            </div>
            <span class="text-xl font-bold text-gray-900 tracking-tight">ZalvlmaX</span>
        </a>
        
        @auth
             <a href="{{ url('/user/dashboard') }}" class="text-sm font-bold bg-indigo-600 text-white px-5 py-2.5 rounded-full hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-200">
                Dashboard
            </a>
        @endauth
    </header>

    <!-- Main Content (Centered Login) -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 py-12 relative z-10 w-full">
        
        <div class="w-full max-w-md">
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    Siap Meningkatkan Kualitas Evaluasi?
                </h1>
                <p class="text-gray-500 max-w-xs mx-auto">
                    Bergabung dengan ratusan pengguna lainnya. Masuk sekarang.
                </p>
            </div>

            <!-- Login Card -->
            <div class="bg-white/95 backdrop-blur-xl p-8 rounded-3xl shadow-2xl border border-white/50 ring-1 ring-indigo-50">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full px-5 py-3 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm placeholder-gray-400"
                               placeholder="nama@email.com">
                        @if($errors->has('email'))
                            <p class="text-red-500 text-xs mt-2">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full px-5 py-3 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm placeholder-gray-400"
                               placeholder="••••••••">
                         @if($errors->has('password'))
                            <p class="text-red-500 text-xs mt-2">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="inline-flex items-center text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lupa password?</a>
                        @endif
                    </div>

                    <!-- Login Button Blue/Indigo -->
                    <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all transform active:scale-95 shadow-lg shadow-indigo-200">
                        Masuk Sekarang
                    </button>
                </form>
            </div>

            @if (Route::has('register'))
                <p class="mt-8 text-center text-gray-500 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:text-indigo-700 ml-1">
                        Daftar Gratis
                    </a>
                </p>
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full py-8 text-center text-gray-400 text-sm relative z-10">
        &copy; {{ date('Y') }} Tim Tata Usaha Kayu. All rights reserved.
    </footer>
    
    <!-- Edge Fade -->
    <div class="fixed inset-0 pointer-events-none bg-[radial-gradient(circle_at_center,transparent_0%,white_100%)] opacity-30 z-0"></div>

</body>
</html>