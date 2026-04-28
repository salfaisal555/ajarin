<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-12">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Katalog Kelas</h1>
                        <p class="text-gray-500 mt-1">Jelajahi dan gabung kelas baru untuk meningkatkan skillmu.</p>
                    </div>
                    <a href="{{ route('student.dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-teal-600">
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
                        <button type="submit" class="px-6 py-3 bg-teal-600 text-white font-bold rounded-r-xl hover:bg-teal-700 transition">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($availableCourses as $course)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col h-full overflow-hidden">
                    
                    <div class="h-40 bg-gradient-to-br from-teal-500 to-blue-600 w-full relative group">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-all"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full border border-white/30">
                                {{ $course->teacher->name ?? 'Kelas Baru' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-3 mb-6 flex-1">{{ $course->description }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                            
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs uppercase">
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
                                <button type="submit" class="px-5 py-2 bg-teal-50 text-teal-700 font-bold rounded-lg hover:bg-teal-600 hover:text-white transition shadow-sm">
                                    Gabung
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    @if(request('search'))
                        <p class="text-gray-900 font-bold text-lg">Tidak ada hasil pencarian.</p>
                        <p class="text-gray-500">Tidak menemukan kelas dengan kata kunci "{{ request('search') }}"</p>
                        <a href="{{ route('student.catalog') }}" class="mt-4 inline-block text-teal-600 font-bold hover:underline">Reset Pencarian</a>
                    @else
                        <p class="text-gray-900 font-bold text-lg">Semua kelas sudah Anda ikuti!</p>
                        <p class="text-gray-500">Saat ini tidak ada kelas baru yang tersedia untuk bergabung.</p>
                    @endif
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>