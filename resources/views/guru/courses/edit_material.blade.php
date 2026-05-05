<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 text-white">
                <a href="{{ route('courses.curriculum', $course->id) }}" 
                   aria-label="Kembali ke susunan kurikulum" 
                   class="p-2 bg-white/20 hover:bg-white/30 rounded-lg transition shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold">Edit Materi</h1>
                    <p class="text-teal-100 mt-1">Kelas: {{ $course->title }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-20 relative z-10">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden p-8 sm:p-10">
            
            <form action="{{ route('materials.update', $material->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Materi</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $material->title) }}" 
                               aria-label="Input judul materi"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                               placeholder="Contoh: Pengenalan Dasar" 
                               required>
                        @error('title')
                            <p class="text-red-500 text-xs font-bold mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="summernote" class="block text-sm font-bold text-gray-700 mb-2">Isi Materi (Teks, Gambar, Video)</label>
                        <textarea id="summernote" name="content">{{ old('content', $material->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs font-bold mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('courses.curriculum', $course->id) }}" 
                       class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-lg hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                    <button type="submit" 
                            aria-label="Simpan semua perubahan materi"
                            class="px-6 py-3 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 shadow-md transition">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <style>
        .note-modal-backdrop {
            z-index: 1040 !important;
        }
        .note-modal {
            z-index: 1050 !important;
        }
    </style>

    <script>
      $(document).ready(function() {
          $('#summernote').summernote({
            placeholder: 'Tulis materi di sini... Anda bisa copy-paste gambar atau embed video YouTube.',
            tabsize: 2,
            height: 400,
            dialogsInBody: true,
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'video']],
              ['view', ['fullscreen', 'codeview', 'help']]
            ]
          });
      });
    </script>
</x-app-layout>