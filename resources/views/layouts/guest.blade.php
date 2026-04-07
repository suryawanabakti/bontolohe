<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('logo-posyandu.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            .auth-bg {
                background: linear-gradient(135deg, #008CB5 0%, #005f7a 100%);
            }
            .animate-fade-in { animation: fadeIn 1s ease-out forwards; }
            .animate-slide-up { animation: slideUp 0.6s ease-out forwards; }
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        </style>
    </head>
    <body class="text-gray-900 antialiased overflow-hidden">
        <div class="min-h-screen flex">
            <!-- Left Side: Branding/Image -->
            <div class="hidden lg:flex w-1/2 auth-bg items-center justify-center p-12 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 100 L100 0 L100 100 Z" fill="white"></path>
                    </svg>
                </div>
                
                <div class="relative z-10 text-center text-white animate-fade-in">
                    <div class="inline-flex p-6 bg-white/10 backdrop-blur-xl rounded-3xl mb-8 border border-white/20">
                        <img src="{{ asset('logo-posyandu.png') }}" alt="Logo" class="h-24 w-auto brightness-0 invert">
                    </div>
                    <h1 class="text-4xl font-extrabold mb-4">Posyandu Bontolohe</h1>
                    <p class="text-xl text-white/80 max-w-sm mx-auto font-light">
                        Sistem Informasi Kesehatan Terpadu untuk Masa Depan yang Lebih Baik.
                    </p>
                </div>
                
                <div class="absolute bottom-8 left-8 text-white/50 text-xs tracking-widest uppercase font-medium">
                    Digital Health Platform &copy; {{ date('Y') }}
                </div>
            </div>

            <!-- Right Side: Content -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
                <div class="w-full max-w-md">
                    <div class="mb-10 lg:hidden text-center">
                        <img src="{{ asset('logo-posyandu.png') }}" alt="Logo" class="h-16 w-auto mx-auto mb-4">
                        <h2 class="text-2xl font-bold text-primary">Posyandu Bontolohe</h2>
                    </div>
                    
                    <div class="animate-slide-up">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
