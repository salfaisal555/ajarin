<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajarin - Platform Pembelajaran Digital</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white selection:bg-teal-500 selection:text-white overflow-x-hidden">

    <nav class="absolute top-0 left-0 right-0 z-50 py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-2 group cursor-pointer">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-500 to-cyan-500 text-white flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <span class="text-2xl font-extrabold text-gray-800 tracking-tight">Ajarin</span>
        </div>

        @if (Route::has('login'))
            <div class="flex items-center gap-3 sm:gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-xl shadow-sm transition-all duration-300">
                        Ke Dashboard &rarr;
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        Masuk
                    </a>
                @endauth
            </div>
        @endif
    </nav>

    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 lg:pb-32 overflow-hidden bg-gray-50">
        <div class="absolute inset-0 pointer-events-none opacity-30">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-20 right-1/4 w-96 h-96 bg-cyan-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-20 left-1/3 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-50 text-teal-700 font-semibold text-sm mb-6 border border-teal-100 shadow-sm">
                <span class="flex h-2 w-2 rounded-full bg-teal-500 animate-pulse"></span>
                Platform Pembelajaran Terpadu
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight mb-6 leading-tight">
                Belajar Lebih Pintar, <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-cyan-600">Mengajar Lebih Mudah</span>
            </h1>
            
            <p class="max-w-2xl mx-auto text-lg sm:text-xl text-gray-600 mb-10 leading-relaxed">
                Ajarin menghubungkan guru dan siswa dalam satu ruang kelas digital yang interaktif, terstruktur, dan mudah digunakan kapan saja, di mana saja.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl shadow-lg shadow-teal-500/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        Buka Ruang Kelas
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl shadow-lg shadow-teal-500/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        Masuk ke Akun
                    </a>
                    <a href="#fitur" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-gray-700 bg-white border-2 border-gray-100 rounded-xl hover:border-teal-100 hover:bg-teal-50 transition-all duration-300">
                        Pelajari Fitur
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div id="fitur" class="py-20 bg-white relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Mengapa Memilih Ajarin?</h2>
                <p class="mt-4 text-lg text-gray-500">Desain modern yang fokus pada kenyamanan belajar mengajar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:border-teal-200 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-teal-500 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Kelas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Guru dapat mengelola materi, tugas, dan ujian dalam satu dashboard yang terorganisir dengan rapi.
                    </p>
                </div>

                <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:border-cyan-200 hover:bg-white hover:shadow-xl transition-all duration-300 group transform md:-translate-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Belajar Terstruktur</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Siswa mendapatkan alur belajar yang jelas, dari materi hingga evaluasi, tanpa takut tertinggal informasi.
                    </p>
                </div>

                <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sistem Cerdas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Penilaian tugas dan monitoring keaktifan siswa berjalan otomatis, memangkas waktu kerja administrasi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="text-lg font-bold text-gray-800">Ajarin App</span>
            </div>
            <p class="text-gray-500 text-sm font-medium">
                &copy; {{ date('Y') }} Skripsi Project. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>