<x-app-layout>
    <div class="bg-white min-h-screen pb-12">
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
            
            <nav class="flex text-sm font-medium text-gray-500 mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    
                    <li class="inline-flex items-center">
                        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center hover:text-teal-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Kelas Saya
                        </a>
                    </li>
                    
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-teal-700 font-bold line-clamp-1 max-w-[200px] sm:max-w-md">{{ $course->title }}</span>
                        </div>
                    </li>
                    
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <h1 class="text-3xl font-bold text-teal-700">{{ $course->title }}</h1>
                <a href="{{ route('student.learning', $course->id) }}" class="inline-block px-6 py-2.5 bg-teal-600 text-white font-bold rounded-lg shadow-md hover:bg-teal-700 transition-colors text-center shrink-0">
                    Belajar Sekarang
                </a>
            </div>

            <div class="text-gray-700 leading-relaxed text-lg mb-4">
                {{ $course->description }}
            </div>
            
            <div class="text-sm font-medium text-gray-500 mb-8 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Guru Pengajar: <span class="text-gray-800">{{ $teacher->name ?? 'Admin' }}</span>
            </div>

            <hr class="border-t-2 border-gray-100 mb-10">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-teal-50 rounded-2xl overflow-hidden border border-teal-100 flex flex-col h-full">
                    <div class="px-6 py-4 border-b border-teal-200 flex items-center gap-3 bg-teal-100/50">
                        <svg class="w-6 h-6 text-teal-800" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        <h2 class="text-lg font-bold text-teal-800">Daftar Evaluasi & Proyek</h2>
                    </div>
                    
                    <div class="p-4 flex-1 space-y-4 max-h-[400px] overflow-y-auto">
                        @forelse($assignments as $assignment)
                            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-md font-bold text-gray-900">{{ $assignment->title }}</h3>
                                    <span class="text-[10px] uppercase font-bold px-2 py-1 rounded {{ $assignment->type == 'project' ? 'bg-indigo-100 text-indigo-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $assignment->type == 'project' ? 'Proyek Kelompok' : 'Ujian Individu' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mb-4">Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}</p>

                                <div class="flex justify-end">
                                    <a href="{{ route('student.assignment.show', $assignment->id) }}" class="px-5 py-2 bg-teal-600 text-white text-sm font-bold rounded-lg hover:bg-teal-700 transition">
                                        Buka & Kerjakan
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 italic py-6">Belum ada tugas atau ujian.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-teal-50 rounded-2xl overflow-hidden border border-teal-100 flex flex-col h-full">
                    <div class="px-6 py-4 border-b border-teal-200 flex items-center gap-3">
                        <svg class="w-6 h-6 text-teal-800" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
                        <h2 class="text-lg font-bold text-teal-800">Diskusi Kelas</h2>
                    </div>
                    
                    <div class="p-4 flex-1">
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 h-full flex flex-col">
                            <h3 class="text-sm font-bold text-gray-900 mb-2">Forum Diskusi</h3>
                            <p class="text-gray-700 mb-6 leading-relaxed">
                                Berdiskusi dengan Guru dan siswa lainnya terkait kelas {{ $course->title }}.
                            </p>

                            <div class="mt-auto flex justify-end pt-4">
                                <a href="{{ route('forum.index', $course->id) }}" class="inline-block px-6 py-2 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition text-center">
                                    Masuk ke Forum
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>