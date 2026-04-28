<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Ajarin</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    <div class="min-h-screen w-full flex overflow-hidden">
        
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-teal-600 via-cyan-600 to-blue-700 p-16 flex-col relative">
            
            <div class="flex items-center gap-3 mb-20 relative z-10">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-teal-600 font-bold text-2xl shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-3xl font-black text-white tracking-wider">Ajarin</span>
            </div>

            <div class="my-auto relative z-10">
                <h1 class="text-5xl xl:text-6xl font-black text-white leading-tight mb-4 tracking-tighter">
                    Platform Belajar
                </h1>
                <h2 class="text-5xl xl:text-6xl font-bold text-yellow-300 italic mb-6">
                    yang Menyenangkan
                </h2>
                <p class="text-teal-50 text-xl max-w-md leading-relaxed opacity-90">
                    Satu platform terintegrasi untuk memudahkan interaksi antara guru, siswa, dan admin sekolah.
                </p>

                <div class="flex flex-wrap gap-3 mt-10">
                    <span class="px-5 py-2.5 rounded-full border border-white/20 bg-white/10 text-white text-sm font-semibold backdrop-blur-md">✓ Manajemen Kelas</span>
                    <span class="px-5 py-2.5 rounded-full border border-white/20 bg-white/10 text-white text-sm font-semibold backdrop-blur-md">✓ Forum Diskusi</span>
                    <span class="px-5 py-2.5 rounded-full border border-white/20 bg-white/10 text-white text-sm font-semibold backdrop-blur-md">✓ Evaluasi Tugas</span>
                    <span class="px-5 py-2.5 rounded-full border border-white/20 bg-white/10 text-white text-sm font-semibold backdrop-blur-md">✓ Tracking Progres</span>
                </div>
            </div>

            <div class="mt-auto grid grid-cols-3 gap-6 relative z-10">
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl hover:bg-white/10 transition-all">
                    <div class="text-3xl font-black text-white">500+</div>
                    <div class="text-sm text-teal-100 font-bold mt-1 uppercase tracking-widest">Siswa</div>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl hover:bg-white/10 transition-all">
                    <div class="text-3xl font-black text-white">50+</div>
                    <div class="text-sm text-teal-100 font-bold mt-1 uppercase tracking-widest">Kelas</div>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl hover:bg-white/10 transition-all">
                    <div class="text-3xl font-black text-white">30+</div>
                    <div class="text-sm text-teal-100 font-bold mt-1 uppercase tracking-widest">Guru</div>
                </div>
            </div>

            <div class="absolute top-0 right-0 w-full h-full opacity-10 pointer-events-none">
                <svg width="100%" height="100%" fill="none" viewBox="0 0 400 400">
                    <defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" stroke="white" stroke-width="1"/></pattern></defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-16 lg:p-24 bg-white relative">
            
            <div class="w-full max-w-md">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm font-bold mb-10">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span> Platform Aktif
                </div>

                <div class="mb-10">
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight">
                        Selamat Datang 👋
                    </h2>
                    <p class="text-gray-500 mt-3 text-lg font-medium">Masuk ke akun Ajarin Anda</p>
                </div>

                <x-auth-session-status class="mb-6 text-sm font-medium text-emerald-600 bg-emerald-50 p-4 rounded-xl shadow-sm border border-emerald-100" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="group">
                        <label for="email" class="block text-sm font-bold text-gray-800 mb-2 group-focus-within:text-teal-600 transition-colors">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-teal-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="pl-12 w-full px-5 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('email') border-red-500 @enderror" 
                                   placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs font-bold mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="password" class="block text-sm font-bold text-gray-800 mb-2 group-focus-within:text-teal-600 transition-colors">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-teal-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            
                            <input id="password" type="password" name="password" required
                                   class="pl-12 pr-12 w-full px-5 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all duration-200 text-gray-900 font-semibold tracking-widest placeholder:tracking-normal placeholder:font-normal placeholder:text-gray-400 @error('password') border-red-500 @enderror" 
                                   placeholder="••••••••">
                            
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-teal-600 focus:outline-none transition-colors">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs font-bold mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-gray-200 text-teal-600 focus:ring-teal-500 transition-all cursor-pointer">
                            <span class="ml-3 text-sm text-gray-600 font-bold group-hover:text-gray-900 transition-colors">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-black text-teal-600 hover:text-teal-700 transition-colors underline decoration-2 underline-offset-4" href="{{ route('password.request') }}">
                                Lupa Sandi?
                            </a>
                        @endif
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center items-center px-6 py-5 text-lg font-black rounded-2xl text-white bg-cyan-600 hover:bg-cyan-700 hover:shadow-2xl hover:shadow-cyan-500/30 active:scale-[0.98] transition-all duration-300">
                            Masuk ke Ajarin 
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            <p class="absolute bottom-10 text-gray-400 text-sm font-medium">
                &copy; {{ date('Y') }} Ajarin App. Platform Skripsi Masa Depan.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');
            
            if (passwordInput.type === 'password') {
                // Ubah ke mode text (lihat password)
                passwordInput.type = 'text';
                passwordInput.classList.remove('tracking-widest'); // Rapikan spasinya
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                // Kembalikan ke mode password (sembunyikan)
                passwordInput.type = 'password';
                passwordInput.classList.add('tracking-widest'); // Jauhkan spasi titik-titiknya
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>

</body>
</html>