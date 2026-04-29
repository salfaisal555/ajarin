<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Proyek Kelompok</h1>
                <p class="text-gray-500">Kelas: {{ $course->title }}</p>
            </div>
            <a href="{{ route('courses.show', $course->id) }}" class="text-gray-500 hover:text-gray-700 font-bold">&larr; Batal</a>
        </div>

        <form action="{{ route('assignments.store_project', $course->id) }}" method="POST">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-md mb-6 border-t-4 border-indigo-500">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Proyek</label>
                        <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500" required placeholder="Contoh: Website Profil Sekolah">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Batas Pengumpulan (Deadline)</label>
                        <input type="datetime-local" name="deadline" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Brief Proyek / Instruksi Pengerjaan</label>
                    <textarea id="summernote" name="description"></textarea>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md mb-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h2 class="text-xl font-bold text-indigo-800">Pembentukan Kelompok</h2>
                    <button type="button" onclick="addGroup()" class="px-4 py-2 bg-indigo-100 text-indigo-700 font-bold rounded-lg hover:bg-indigo-200 transition shadow-sm">
                        + Tambah Kelompok
                    </button>
                </div>

                <div id="groupsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group-item bg-gray-50 border border-gray-200 rounded-xl p-5 relative">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Kelompok</label>
                        <input type="text" name="groups[0][name]" class="w-full rounded-lg border-gray-300 mb-4 font-bold text-indigo-700" value="Kelompok 1" required>
                        
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Anggota Siswa</label>
                        <div class="max-h-40 overflow-y-auto space-y-1 bg-white p-3 rounded-lg border border-gray-200">
                            @forelse($students as $student)
                                <label class="flex items-center space-x-3 cursor-pointer p-1.5 hover:bg-gray-50 rounded transition-colors duration-200">
                                    <input type="checkbox" name="groups[0][students][]" value="{{ $student->id }}" class="student-checkbox rounded text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                    <span class="text-sm font-medium text-gray-700">{{ $student->name }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-red-500 italic">Belum ada siswa yang mendaftar di kelas ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg transition active:scale-95">
                    Simpan Proyek & Kelompok
                </button>
            </div>
        </form>
    </div>

    <script>
        // Inisialisasi Summernote
        $('#summernote').summernote({
            placeholder: 'Tuliskan instruksi lengkap untuk proyek ini...',
            tabsize: 2, height: 200,
            toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol']], ['insert', ['link']]]
        });

        // LOGIKA ANTI-DUPLIKAT ANGGOTA KELOMPOK
        document.addEventListener('DOMContentLoaded', function() {
            // Pasang event listener ke container utama agar mendeteksi perubahan pada checkbox
            document.getElementById('groupsContainer').addEventListener('change', function(e) {
                if (e.target.classList.contains('student-checkbox')) {
                    updateStudentCheckboxes();
                }
            });
        });

        function updateStudentCheckboxes() {
            const allCheckboxes = document.querySelectorAll('.student-checkbox');
            
            // 1. Kumpulkan semua ID siswa yang sedang dicentang (di semua kelompok)
            const checkedIds = Array.from(allCheckboxes)
                                    .filter(cb => cb.checked)
                                    .map(cb => cb.value);

            // 2. Loop semua checkbox untuk mematikan yang ID-nya sudah terpilih
            allCheckboxes.forEach(cb => {
                const label = cb.closest('label');
                
                if (checkedIds.includes(cb.value) && !cb.checked) {
                    // Jika siswa terpilih di tempat lain, matikan checkbox ini dan buat jadi abu-abu
                    cb.disabled = true;
                    label.classList.add('opacity-40', 'cursor-not-allowed', 'bg-gray-100');
                    label.classList.remove('hover:bg-gray-50', 'cursor-pointer');
                } else {
                    // Jika belum terpilih, aktifkan kembali
                    cb.disabled = false;
                    label.classList.remove('opacity-40', 'cursor-not-allowed', 'bg-gray-100');
                    label.classList.add('hover:bg-gray-50', 'cursor-pointer');
                }
            });
        }

        let gIndex = 1;
        function addGroup() {
            const container = document.getElementById('groupsContainer');
            
            // Render ulang daftar siswa untuk kelompok baru
            const studentsHtml = `
                @foreach($students as $student)
                    <label class="flex items-center space-x-3 cursor-pointer p-1.5 hover:bg-gray-50 rounded transition-colors duration-200">
                        <input type="checkbox" name="groups[${gIndex}][students][]" value="{{ $student->id }}" class="student-checkbox rounded text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">{{ $student->name }}</span>
                    </label>
                @endforeach
            `;

            const html = `
                <div class="group-item bg-gray-50 border border-gray-200 rounded-xl p-5 relative mt-4 md:mt-0">
                    <button type="button" onclick="this.parentElement.remove(); updateStudentCheckboxes();" class="absolute top-4 right-4 text-red-400 hover:text-red-600 transition-colors" title="Hapus Kelompok">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Kelompok</label>
                    <input type="text" name="groups[${gIndex}][name]" class="w-full rounded-lg border-gray-300 mb-4 font-bold text-indigo-700" value="Kelompok ${gIndex + 1}" required>
                    
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Anggota Siswa</label>
                    <div class="max-h-40 overflow-y-auto space-y-1 bg-white p-3 rounded-lg border border-gray-200">
                        ${studentsHtml}
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            gIndex++;
            
            // Jalankan fungsi update agar siswa yang sudah dipilih sebelumnya langsung disable di kotak baru ini
            updateStudentCheckboxes();
        }
    </script>
</x-app-layout>