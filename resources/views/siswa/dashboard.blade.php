<x-app-layout>
    <div class="relative bg-gradient-to-r from-teal-600 to-cyan-600 h-64 overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute inset-0 flex flex-col justify-center px-8 sm:px-12 text-white">
            <h1 class="text-3xl sm:text-4xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-teal-100 text-lg">Lanjutkan progres belajarmu hari ini.</p>
        </div>
        <div class="absolute -right-10 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 pb-12">
        
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-2xl font-bold text-gray-800 bg-white/80 backdrop-blur px-4 py-2 rounded-lg shadow-sm">Kelas Saya</h2>
            <a href="{{ route('student.catalog') }}" class="text-sm font-bold text-teal-600 bg-white px-4 py-2 rounded-lg shadow hover:bg-gray-50 transition">
                + Tambah Kelas Baru
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($myCourses as $course)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all group">
                <div class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600 p-6 relative">
                    <h3 class="text-xl font-bold text-white relative z-10">{{ $course->title }}</h3>
                    <div class="absolute bottom-0 right-0 p-4 opacity-20 group-hover:opacity-30 transition">
                        <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-500 text-sm line-clamp-2 mb-6 h-10">{{ $course->description }}</p>
                    
                    <a href="{{ route('student.corridor', $course->id) }}" class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition shadow-lg hover:shadow-teal-500/30">
                        Lihat Koridor Kelas &rarr;
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-2xl shadow-lg">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Belum ada kelas diambil</h3>
                <p class="text-gray-500 mt-2 mb-6">Yuk, cari kelas menarik di katalog!</p>
                <a href="{{ route('student.catalog') }}" class="px-6 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-lg hover:bg-teal-700 transition">
                    Lihat Katalog Kelas
                </a>
                        </div>
            @endforelse
        </div>
    </div>
</x-app-layout>