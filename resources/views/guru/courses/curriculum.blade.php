<x-app-layout>
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-white gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('courses.index') }}" class="p-2 bg-white/20 hover:bg-white/30 rounded-lg transition text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold">Edit Kurikulum</h1>
                        <p class="text-teal-100 mt-1">Kelas: {{ $course->title }}</p>
                    </div>
                </div>
                <a href="{{ route('courses.show', $course->id) }}" class="px-4 py-2 bg-white text-teal-700 font-bold rounded-lg shadow hover:bg-teal-50 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat Mode Monitoring
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-12 relative z-10">
        
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center mb-6">
            <p>{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-teal-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Susunan Materi</h3>
                        <p class="text-sm text-gray-500">Atur konten pembelajaran secara sekuensial.</p>
                    </div>
                    <button onclick="document.getElementById('modalTambahBab').classList.remove('hidden')" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition shadow-lg hover:-translate-y-0.5">
                        + Tambah Bab Baru
                    </button>
                </div>

                @forelse($course->chapters as $chapter)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <span class="bg-teal-100 text-teal-800 text-xs font-bold px-2 py-1 rounded">BAB {{ $loop->iteration }}</span>
                            <h4 class="font-bold text-gray-800 text-lg">{{ $chapter->title }}</h4>
                            
                            <button onclick="editBab('{{ $chapter->id }}', '{{ $chapter->title }}')" class="text-gray-400 hover:text-blue-600 transition ml-2" title="Edit Nama Bab">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST" onsubmit="return confirm('Hapus Bab ini?');">
                                @csrf @method('DELETE')
                                <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        @forelse($chapter->materials as $material)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-teal-50/50 transition group bg-white">
                            <div class="flex items-center gap-4">
                                @if($material->type == 'pdf')
                                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-lg flex items-center justify-center"><span class="text-xs font-bold">PDF</span></div>
                                @elseif($material->type == 'video')
                                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                @else
                                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></div>
                                @endif
                                <div>
                                    <h5 class="font-bold text-gray-800">{{ $material->title }}</h5>
                                    <p class="text-xs text-gray-400 font-mono mt-0.5 uppercase">{{ $material->type }}</p>
                                </div>
                            </div>
                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                                @csrf @method('DELETE')
                                <button class="text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition p-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                        @empty
                            <p class="text-sm text-gray-400 italic text-center">Belum ada materi.</p>
                        @endforelse
                        
                        <div class="mt-4 flex justify-center">
                            <a href="{{ route('materials.create', $chapter->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-teal-200 rounded-lg text-sm font-bold text-teal-600 hover:bg-teal-50 transition shadow-sm">
                                + Tambah Materi
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <p class="text-gray-500 mb-4">Belum ada Bab.</p>
                    <button onclick="document.getElementById('modalTambahBab').classList.remove('hidden')" class="px-6 py-2 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700">Buat Bab Pertama</button>
                </div>
                @endforelse
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-indigo-500 relative">
                    <button onclick="document.getElementById('modalEditKelas').classList.remove('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-indigo-600 p-2 rounded-lg hover:bg-indigo-50 transition" title="Edit Info Kelas">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </button>

                    <h3 class="font-bold text-gray-800 mb-4 text-lg">Informasi Kelas</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Judul Kelas</span>
                            <p class="text-gray-800 font-medium">{{ $course->title }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi</span>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $course->description }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Kode Kelas</span>
                            <code class="bg-gray-100 px-3 py-1.5 rounded-lg text-indigo-600 font-mono font-bold border border-gray-200 mt-1 inline-block">CS-{{ $course->id }}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalTambahBab" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Tambah Bab Baru</h3>
            <form action="{{ route('chapters.store', $course->id) }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Bab</label>
                    <input type="text" name="title" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-teal-500 focus:border-teal-500" placeholder="Contoh: Bab 1 - Pendahuluan" required>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambahBab').classList.add('hidden')" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditBab" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Edit Nama Bab</h3>
            <form id="formEditBab" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Bab</label>
                    <input type="text" name="title" id="inputEditBabTitle" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-teal-500 focus:border-teal-500" required>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalEditBab').classList.add('hidden')" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditKelas" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Edit Informasi Kelas</h3>
            <form action="{{ route('courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Kelas</label>
                    <input type="text" name="title" value="{{ $course->title }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500" required>{{ $course->description }}</textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalEditKelas').classList.add('hidden')" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editBab(id, title) {
            // Set Value Input
            document.getElementById('inputEditBabTitle').value = title;
            // Set Form Action URL secara dinamis
            let url = "{{ route('chapters.update', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('formEditBab').action = url;
            
            // Tampilkan Modal
            document.getElementById('modalEditBab').classList.remove('hidden');
        }
    </script>
</x-app-layout>