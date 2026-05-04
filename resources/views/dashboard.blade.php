<x-app-layout>
    <div class="relative bg-gradient-to-br from-teal-500 via-cyan-600 to-blue-600 overflow-hidden mb-8">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-white/90 text-base sm:text-lg">
                        Selamat datang kembali di <span class="font-bold underline decoration-yellow-400">Ajarin</span>. 
                        @if(Auth::user()->role == 'admin')
                            Semua sistem berjalan normal hari ini.
                        @elseif(Auth::user()->role == 'guru')
                            Siap untuk mengajar kelas hari ini?
                        @else
                            Ayo lanjutkan perjalanan belajarmu!
                        @endif
                    </p>
                </div>
                
                @if(Auth::user()->role == 'admin')
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white text-teal-600 font-bold rounded-xl shadow-lg hover:bg-teal-50 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah User
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        
        @if(Auth::user()->role == 'admin')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-teal-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center group-hover:bg-teal-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Siswa</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $totalSiswa ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-blue-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Guru</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $totalGuru ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-cyan-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Kelas Aktif</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $totalKelas ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h4 class="text-lg font-bold text-gray-800">Akun Terbaru</h4>
                        <a href="{{ route('users.index') }}" class="text-sm font-bold text-teal-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Role</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Dibuat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($latestUsers as $user)
                                <tr class="hover:bg-teal-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-bold text-gray-700">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $user->role == 'guru' ? 'bg-blue-100 text-blue-700' : 'bg-teal-100 text-teal-700' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">Belum ada akun baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h4>
                        <div class="grid grid-cols-1 gap-3">
                            <button onclick="openAddModal()" class="flex items-center gap-4 p-4 rounded-2xl bg-teal-50 text-teal-700 hover:bg-teal-100 transition-all font-bold">
                                <div class="p-2 rounded-lg bg-white shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                </div>
                                Tambah Akun Manual
                            </button>
                            <button onclick="openImportModal()" class="flex items-center gap-4 p-4 rounded-2xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition-all font-bold">
                                <div class="p-2 rounded-lg bg-white shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                Import Siswa (Excel)
                            </button>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-3xl shadow-xl text-white">
                        <h4 class="font-bold mb-2 text-teal-400">Tips Admin 💡</h4>
                        <p class="text-sm text-gray-300 leading-relaxed italic">
                            "Gunakan fitur Import Excel untuk mendaftarkan satu kelas sekaligus agar lebih efisien dan terhindar dari kesalahan pengetikan."
                        </p>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->role == 'guru')
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-teal-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center group-hover:bg-teal-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Kelas</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $totalKelas ?? 0 }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-blue-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Siswa</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $totalSiswa ?? 0 }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-purple-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Tugas</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $totalTugas ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-gray-800">Kelas yang Diampu</h4>
                    <a href="{{ route('courses.index') }}" class="text-sm font-bold text-teal-600 hover:underline">Lihat Semua &rarr;</a>
                </div>
                @forelse($courses ?? [] as $course)
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 hover:bg-teal-50/30 transition">
                    <div>
                        <p class="font-bold text-gray-800">{{ $course->title }}</p>
                        <p class="text-sm text-gray-500">{{ $course->students_count }} siswa terdaftar</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('courses.show', $course->id) }}" class="px-4 py-2 text-sm font-bold text-teal-700 bg-teal-50 rounded-lg hover:bg-teal-100 transition">Monitoring</a>
                        <a href="{{ route('forum.index', $course->id) }}" class="px-4 py-2 text-sm font-bold text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">Forum</a>
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-gray-400">
                    <p>Belum ada kelas. <a href="{{ route('courses.create') }}" class="text-teal-600 font-bold hover:underline">Buat kelas pertama &rarr;</a></p>
                </div>
                @endforelse
            </div>

        @elseif(Auth::user()->role == 'siswa')
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-cyan-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Kelas Diikuti</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $totalKelasSiswa ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-rose-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Tugas Aktif</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $tugasAktif ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex items-center gap-5 group hover:border-yellow-300 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center group-hover:bg-yellow-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Poin Belajar</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $poinBelajar ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden p-6 sm:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-lg font-bold text-gray-800">Lanjutkan Belajarmu 🚀</h4>
                        <a href="{{ route('student.dashboard') }}" class="text-sm font-bold text-cyan-600 hover:underline">Lihat Semua Kelas</a>
                    </div>
                    
                    <div class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1">Belum ada kelas yang diikuti</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">Kamu belum mendaftar ke kelas manapun. Yuk, cari materi yang menarik di katalog!</p>
                        
                        <a href="{{ route('student.catalog') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 transition-all transform hover:-translate-y-0.5">
                            Jelajahi Katalog Kelas
                        </a>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-cyan-500 to-blue-600 p-6 rounded-3xl shadow-xl text-white relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                        <div class="absolute right-10 -bottom-6 w-16 h-16 bg-white opacity-10 rounded-full"></div>
                        
                        <h4 class="font-bold mb-2 text-lg relative z-10">Katalog Kelas 📚</h4>
                        <p class="text-sm text-cyan-100 mb-6 leading-relaxed relative z-10">
                            Temukan berbagai materi pelajaran baru yang sesuai dengan minatmu di sini.
                        </p>
                        <a href="{{ route('student.catalog') }}" class="block w-full py-3 px-4 bg-white text-cyan-600 text-center font-bold rounded-xl shadow-sm hover:bg-cyan-50 hover:shadow-md transition-all relative z-10">
                            Buka Katalog
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Butuh Bantuan?</h4>
                        <p class="text-sm text-gray-500 mb-4">Jika kamu kesulitan mengakses materi, segera hubungi admin atau gurumu.</p>
                        <a href="#" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-rose-50 text-rose-600 text-center font-bold rounded-xl hover:bg-rose-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pusat Bantuan
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        @keyframes blob { 0%, 100% { transform: translate(0, 0) scale(1); } 33% { transform: translate(30px, -50px) scale(1.1); } 66% { transform: translate(-20px, 20px) scale(0.9); } }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</x-app-layout>