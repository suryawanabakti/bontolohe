<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posyandu Bontolohe - Digital Health Monitoring</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
            opacity: 0;
        }
        .animate-slide-up {
            animation: slideUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .feature-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="antialiased text-slate-900 hero-gradient min-h-screen">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo-posyandu.png') }}" alt="Logo" class="h-10 w-auto">
                <span class="font-bold text-xl tracking-tight text-primary">Posyandu Bontolohe</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8 font-medium text-slate-600">
                <a href="#features" class="hover:text-primary transition-colors">Layanan</a>
                <a href="#about" class="hover:text-primary transition-colors">Tentang</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">Dashboard</a>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">Masuk</a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-slide-up">
                <span class="inline-block px-4 py-1.5 bg-primary-light text-primary rounded-full text-sm font-semibold mb-6 uppercase tracking-wider">Terpercaya & Berbasis Digital</span>
                <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Membangun Generasi <br>
                    <span class="text-primary tracking-tight">Sehat & Cerdas</span> <br>
                    dari Bontolohe
                </h1>
                <p class="text-slate-600 text-lg mb-10 leading-relaxed max-w-lg">
                    Sistem pemantauan kesehatan digital untuk ibu, anak, dan lansia. Memastikan setiap tahapan pertumbuhan terpantau secara akurat dan tepat waktu.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary-dark transition-all shadow-xl shadow-primary/20 transform hover:scale-105">
                        Masuk Ke Akun
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-xl font-bold text-lg hover:bg-slate-50 transition-all transform hover:scale-105">
                        Pelajari Layanan
                    </a>
                </div>
            </div>
            
            <div class="relative animate-fade-in group" style="animation-delay: 0.3s">
                <div class="absolute -inset-4 bg-gradient-to-r from-primary to-cyan-400 rounded-3xl opacity-20 group-hover:opacity-30 blur-2xl transition-all duration-500"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white/50">
                    <img src="{{ asset('images/hero-posyandu.png') }}" alt="Posyandu" class="w-full h-auto object-cover transform transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60 to-transparent text-white">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-white/20 backdrop-blur-md rounded-full ring-1 ring-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-xl leading-none">100% Digital</p>
                                <p class="text-white/80 text-sm mt-1">Pemantauan Real-time & Terintegrasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <p class="text-4xl font-bold text-primary mb-1">500+</p>
                    <p class="text-slate-500 font-medium uppercase text-xs tracking-widest">Penerima Layanan</p>
                </div>
                <div class="text-center border-l border-slate-100">
                    <p class="text-4xl font-bold text-primary mb-1">100%</p>
                    <p class="text-slate-500 font-medium uppercase text-xs tracking-widest">Data Terakreditasi</p>
                </div>
                <div class="text-center border-l border-slate-100">
                    <p class="text-4xl font-bold text-primary mb-1">24/7</p>
                    <p class="text-slate-500 font-medium uppercase text-xs tracking-widest">Akses Informasi</p>
                </div>
                <div class="text-center border-l border-slate-100">
                    <p class="text-4xl font-bold text-primary mb-1">A+</p>
                    <p class="text-slate-500 font-medium uppercase text-xs tracking-widest">Standar Posyandu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="features" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-3xl lg:text-4xl font-bold mb-6 underline decoration-primary/20 underline-offset-8">Layanan Kesehatan <span class="text-primary">Terintegrasi</span></h2>
                <p class="text-slate-600 text-lg">Kami menyediakan berbagai layanan kesehatan primer untuk memastikan kesejahteraan seluruh anggota keluarga Anda.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-10">
                <!-- Balita -->
                <div class="feature-card group p-10 bg-white rounded-[2.5rem] text-left border border-slate-100 hover:border-primary/20 transition-all shadow-sm hover:shadow-2xl">
                    <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mb-10 group-hover:bg-primary group-hover:text-white transition-colors duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Pemantauan Balita</h3>
                    <p class="text-slate-600 leading-relaxed">Pencatatan BB, TB, status KMS, dan imunisasi berkala untuk memastikan pertumbuhan optimal si kecil.</p>
                </div>

                <!-- Ibu Hamil -->
                <div class="feature-card group p-10 bg-white rounded-[2.5rem] text-left border border-slate-100 hover:border-primary/20 transition-all shadow-sm hover:shadow-2xl text-slate-800">
                    <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mb-10 group-hover:bg-primary group-hover:text-white transition-colors duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Layanan Ibu Hamil</h3>
                    <p class="text-slate-600 leading-relaxed">Monitoring kesehatan kehamilan, suplemen vitamin, dan edukasi persiapan persalinan yang komprehensif.</p>
                </div>

                <!-- Lansia -->
                <div class="feature-card group p-10 bg-white rounded-[2.5rem] text-left border border-slate-100 hover:border-primary/20 transition-all shadow-sm hover:shadow-2xl">
                    <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mb-10 group-hover:bg-primary group-hover:text-white transition-colors duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Layanan Lansia</h3>
                    <p class="text-slate-600 leading-relaxed">Pemeriksaan darah, gula darah, dan pemantauan kesehatan rutin untuk kualitas hidup lansia yang lebih baik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-slate-900 rounded-[3rem] p-12 lg:p-20 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 w-80 h-80 bg-primary/10 blur-[100px] -mr-40 -mt-40"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-cyan-600/10 blur-[100px] -ml-40 -mb-40"></div>
                
                <div class="relative z-10">
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-8 leading-tight">Siap Bergabung dengan <br> Masa Depan Kesehatan Digital?</h2>
                    <p class="text-slate-400 text-lg mb-12 max-w-2xl mx-auto italic leading-relaxed">
                        "Kesehatan adalah anugerah terbesar. Mari pantau dan jaga bersama tim Posyandu Bontolohe menggunakan teknologi terkini."
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-5 bg-primary text-white rounded-2xl font-bold text-xl hover:bg-primary-dark transition-all shadow-xl shadow-primary/20 transform hover:scale-105 active:scale-95">
                            Masuk Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-10">
                <div class="flex flex-col items-center md:items-start gap-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('logo-posyandu.png') }}" alt="Logo" class="h-10 w-auto">
                        <span class="font-bold text-xl tracking-tight text-slate-800">Posyandu Bontolohe</span>
                    </div>
                    <p class="text-slate-500 max-w-xs text-center md:text-left">Solusi digital untuk masyarakat sehat di Desa Bontolohe.</p>
                </div>
                
                <div class="flex flex-col items-center md:items-end gap-6 text-slate-600">
                    <div class="flex gap-8 font-semibold uppercase text-xs tracking-widest">
                        <a href="#features" class="hover:text-primary transition-colors">Layanan</a>
                        <a href="#about" class="hover:text-primary transition-colors">Tentang Kami</a>
                        <a href="#" class="hover:text-primary transition-colors">Bantuan</a>
                    </div>
                    <p class="text-slate-400 text-sm">
                        &copy; {{ date('Y') }} Posyandu Bontolohe. Dikelola oleh Tim Kader Kesehatan.
                    </p>
                </div>
            </div>
            
            <div class="mt-16 pt-8 border-t border-slate-100 text-center">
                <p class="text-slate-400 text-xs tracking-widest uppercase font-medium">Bontolohe, Sulawesi Selatan, Indonesia</p>
            </div>
        </div>
    </footer>
</body>
</html>
