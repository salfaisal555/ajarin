<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-12">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Katalog Kelas</h1>
                        <p class="text-gray-500 mt-1">Jelajahi dan gabung kelas baru untuk meningkatkan skillmu.</p>
                    </div>
                    <a href="{{ route('student.dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-teal-600 transition">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <form action="{{ route('student.catalog') }}" method="GET" class="flex max-w-xl">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas atau deskripsi..." class="w-full pl-10 pr-4 py-3 rounded-l-xl border border-gray-200 focus:border-teal-500 focus:ring-teal-500 bg-gray-50 focus:bg-white transition">
                        </div>
                        <button type="submit" class="px-6 py-3 bg-teal-600 text-white font-bold rounded-r-xl hover:bg-teal-700 transition shadow-sm hover:shadow">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($availableCourses as $course)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col h-full overflow-hidden group">
                    
                    <!-- PERBAIKAN: Gradient Teal/Cyan yang sama dengan Kelas Saya -->
                    <div class="h-40 bg-gradient-to-br from-teal-500 to-cyan-600 w-full relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-all"></div>
                        
                        <!-- PERBAIKAN: Ornamen Icon Bintang Background -->
                        <div class="absolute bottom-0 right-0 p-4 opacity-20 group-hover:opacity-30 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-24 h-24 text-white -mb-4 -mr-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        </div>

                        <div class="absolute bottom-4 left-4 z-10">
                            <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full border border-white/30 shadow-sm">
                                {{ $course->teacher->name ?? 'Kelas Baru' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-teal-700 transition-colors">{{ $course->title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-3 mb-6 flex-1">{{ $course->description }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs uppercase shadow-inner">
                                    {{ substr($course->teacher->name ?? 'A', 0, 1) }}
                                </div>
                                <div class="text-xs">
                                    <p class="text-gray-400 font-medium">Pengajar</p>
                                    <p class="text-gray-800 font-bold max-w-[100px] truncate" title="{{ $course->teacher->name ?? 'Admin' }}">
                                        {{ $course->teacher->name ?? 'Admin' }}
                                    </p>
                                </div>
                            </div>
                            
                            <form action="{{ route('student.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-teal-50 text-teal-700 font-bold rounded-xl hover:bg-teal-600 hover:text-white transition shadow-sm hover:shadow-md active:scale-95">
                                    Gabung
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300 shadow-sm">
                    <!-- PERBAIKAN: Warna empty state Teal agar konsisten -->
                    <div class="w-20 h-20 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    
                    @if(request('search'))
                        <p class="text-gray-900 font-bold text-lg">Tidak ada hasil pencarian.</p>
                        <p class="text-gray-500 mt-1">Tidak menemukan kelas dengan kata kunci "{{ request('search') }}"</p>
                        <a href="{{ route('student.catalog') }}" class="mt-4 inline-block px-4 py-2 bg-gray-100 text-teal-600 rounded-lg font-bold hover:bg-gray-200 transition">Reset Pencarian</a>
                    @else
                        <p class="text-gray-900 font-bold text-lg">Semua kelas sudah Anda ikuti!</p>
                        <p class="text-gray-500 mt-1">Saat ini tidak ada kelas baru yang tersedia untuk bergabung.</p>
                    @endif
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>