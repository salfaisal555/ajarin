<x-app-layout>
    <div class="relative bg-gradient-to-br from-teal-500 via-cyan-600 to-blue-600 overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-pink-600 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-rose-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-start md:items-center gap-4 w-full md:w-auto">
                    <a href="{{ route('courses.index') }}" class="p-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all duration-200 backdrop-blur-sm flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white">Monitoring: {{ $course->title }}</h1>
                        <p class="text-white/90 mt-1 text-sm sm:text-base">Pantau aktivitas, progress siswa, dan kelompok</p>
                    </div>
                </div>
                
                <a href="{{ route('courses.curriculum', $course->id) }}" class="inline-flex items-center px-6 py-3 bg-white text-teal-600 font-bold rounded-xl shadow-lg hover:bg-teal-50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Materi / Bab
                </a>
                <a href="{{ route('forum.index', $course->id) }}" class="inline-flex items-center px-6 py-3 bg-white/20 text-white font-bold rounded-xl hover:bg-white/30 transition-all duration-300 backdrop-blur-sm mr-2">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
    Forum Kelas
</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-12 relative z-10">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-indigo-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm font-medium">Total Siswa</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $students->count() }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm font-medium">Selesai Kelas</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $students->where('progress_percent', 100)->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-orange-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm font-medium">Total Kelompok</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $course->assignments->where('type', 'project')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Progress Belajar Siswa
                    </h3>
                    <a href="{{ route('courses.export', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition shadow-sm">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
    Export CSV
</a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-1/3">Progress</th>
                            <th class="px-4 sm:px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($students as $student)
                        <tr class="hover:bg-gradient-to-r hover:from-indigo-50/30 hover:to-purple-50/30 transition-all duration-200">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 sm:h-12 sm:w-12">
                                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-base sm:text-lg shadow-lg">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-3 sm:ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $student->name }}</div>
                                        <div class="text-xs sm:text-sm text-gray-500">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if($student->progress_percent >= 100)
                                    <span class="px-3 py-1.5 inline-flex text-xs font-bold rounded-full bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Selesai
                                    </span>
                                @elseif($student->progress_percent > 0)
                                    <span class="px-3 py-1.5 inline-flex text-xs font-bold rounded-full bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800 border border-yellow-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Belajar
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 inline-flex text-xs font-bold rounded-full bg-gradient-to-r from-gray-100 to-gray-50 text-gray-800 border border-gray-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Belum Mulai
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="w-full">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-medium text-gray-600">Progress</span>
                                        <span class="text-xs font-bold text-indigo-600">{{ number_format($student->progress_percent, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner overflow-hidden">
                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500 shadow-sm" style="width: {{ $student->progress_percent }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                                @php
                                    // Mengambil rata-rata SEMUA nilai (Ujian Individual & Proyek Kelompok)
                                    $avgScore = \App\Models\AssignmentScore::where('student_id', $student->id)
                                        ->whereHas('assignment', function($q) use ($course) {
                                            $q->where('course_id', $course->id);
                                        })->avg('score');
                                @endphp
                                
                                @if(is_numeric($avgScore))
                                    <span class="text-base font-black {{ $avgScore >= 70 ? 'text-green-600' : 'text-red-500' }}">
                                        {{ round($avgScore) }}
                                    </span>
                                @else
                                    <span class="text-sm font-bold text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-bold text-gray-700 mb-1">Belum ada siswa</p>
                                    <p class="text-sm text-gray-500">Belum ada siswa yang mendaftar di kelas ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Manajemen Ujian & Proyek
                </h3>
                
                <button onclick="document.getElementById('modalBuatUjian').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg transition-all duration-200 flex items-center transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Ujian / Proyek
                </button>
            </div>
            
            <div class="p-6">
                <div class="space-y-6">
                    @forelse($course->assignments as $assignment)
                        <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h4 class="font-bold text-gray-800 text-lg">{{ $assignment->title }}</h4>
                                        
                                        <div class="flex items-center gap-1 border-l pl-3 ml-2 border-gray-300">
                                            <a href="{{ route('assignments.edit', $assignment->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-md transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus ujian/proyek ini? Semua data nilai dan link siswa akan ikut terhapus!');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <span class="text-xs uppercase font-bold px-2 py-0.5 rounded mt-1 inline-block {{ $assignment->type == 'project' ? 'bg-indigo-100 text-indigo-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $assignment->type == 'project' ? 'Project Test' : 'Individual Test' }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 font-bold uppercase">Deadline</p>
                                    <p class="text-sm font-medium text-red-500">{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            @if($assignment->type == 'project')
                                <div class="p-6 bg-white">
                                    <h5 class="font-bold text-gray-700 mb-4 text-sm uppercase tracking-wider">Monitoring Kelompok</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($assignment->groups as $group)
                                            <div class="border border-indigo-100 bg-indigo-50/30 rounded-lg p-4">
                                                <h6 class="font-bold text-indigo-800 mb-2">{{ $group->name }}</h6>
                                                
                                                <div class="space-y-2 text-sm">
                                                    <div>
                                                        <span class="text-xs text-gray-500 block">Link Monitoring:</span>
                                                        @if($group->monitoring_link)
                                                            <a href="{{ $group->monitoring_link }}" target="_blank" class="text-blue-600 hover:underline truncate block">Buka Link &nearr;</a>
                                                        @else
                                                            <span class="text-red-400 italic">Belum dikirim</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-gray-500 block">Link Final:</span>
                                                        @if($group->final_link)
                                                            <a href="{{ $group->final_link }}" target="_blank" class="text-green-600 hover:underline font-bold truncate block">Buka Hasil Final &nearr;</a>
                                                        @else
                                                            <span class="text-red-400 italic">Belum dikirim</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mt-4 pt-3 border-t border-indigo-100">
                                                    @php
                                                        // Cek apakah kelompok ini sudah dinilai (ambil nilai dari anggota pertama sebagai acuan)
                                                        $firstMember = $group->members->first();
                                                        $groupScore = $firstMember ? \App\Models\AssignmentScore::where('assignment_id', $assignment->id)->where('student_id', $firstMember->id)->value('score') : null;
                                                    @endphp
                                                    <form action="{{ route('assignments.grade_project', $group->id) }}" method="POST" class="flex items-center gap-2">
                                                        @csrf
                                                        <label class="text-xs font-bold text-indigo-900">Nilai:</label>
                                                        <input type="number" name="score" value="{{ $groupScore }}" min="0" max="100" class="w-16 text-sm font-bold text-center rounded-md border-gray-300 py-1 px-2 focus:ring-indigo-500" placeholder="-" required>
                                                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-md hover:bg-indigo-700 transition shadow-sm">Simpan</button>
                                                    </form>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="p-6 bg-white">
                                    <p class="text-sm text-gray-500">Fitur penilaian otomatis Ujian Pilihan Ganda aktif. Nilai siswa akan muncul di sini setelah mengerjakan.</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <p>Belum ada ujian atau proyek yang dibuat untuk kelas ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div> <div id="modalBuatUjian" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-2xl mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Pilih Jenis Evaluasi</h3>
                <button onclick="document.getElementById('modalBuatUjian').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <a href="{{ route('assignments.create', ['course' => $course->id, 'type' => 'individual']) }}" class="group border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 hover:bg-blue-50 transition block text-center cursor-pointer">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Individual Test</h4>
                    <p class="text-sm text-gray-500">Evaluasi mandiri menggunakan soal Pilihan Ganda (PG).</p>
                </a>

                <a href="{{ route('assignments.create', ['course' => $course->id, 'type' => 'project']) }}" class="group border-2 border-gray-200 rounded-xl p-6 hover:border-indigo-500 hover:bg-indigo-50 transition block text-center cursor-pointer">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Project Test (Kelompok)</h4>
                    <p class="text-sm text-gray-500">Beri brief proyek, bagi kelompok otomatis, dan monitor link tugas.</p>
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</x-app-layout>