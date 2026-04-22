<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-12">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Katalog Kelas</h1>
                        <p class="text-gray-500 mt-1">Jelajahi dan gabung kelas baru untuk meningkatkan skillmu.</p>
                    </div>
                    <a href="{{ route('student.dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-teal-600">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($availableCourses as $course)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col h-full">
                    <div class="h-40 bg-gray-200 w-full relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-teal-600 text-white text-xs font-bold px-2 py-1 rounded">Kelas Baru</span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-3 mb-4 flex-1">{{ $course->description }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div class="text-xs text-gray-400">
                                👨‍🏫 Guru Pengajar
                            </div>
                            
                            <form action="{{ route('student.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2 bg-teal-50 text-teal-700 font-bold rounded-lg hover:bg-teal-600 hover:text-white transition">
                                    Gabung Kelas
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-500 text-lg">Saat ini belum ada kelas baru yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>