<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-white">Tulis Materi Baru</h1>
            <p class="text-teal-100 mt-1">Bab: {{ $chapter->title }}</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-12 relative z-10">
        <div class="bg-white rounded-xl shadow-xl p-8">
            
            <form action="{{ route('materials.store', $chapter->id) }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Materi</label>
                    <input type="text" name="title" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-teal-500" placeholder="Judul Materi..." required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Isi Materi (Teks, Gambar, Video)</label>
                    <textarea id="summernote" name="content"></textarea>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <a href="{{ route('courses.curriculum', $chapter->course_id) }}" class="px-6 py-3 mr-3 text-gray-600 font-bold hover:bg-gray-100 rounded-lg">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 shadow-lg">Simpan Materi</button>
                </div>
            </form>

        </div>
    </div>
<style>
        /* Memaksa Modal Summernote tampil paling depan di atas layout Tailwind */
        .note-modal-backdrop {
            z-index: 1040 !important;
        }
        .note-modal {
            z-index: 1050 !important;
        }
    </style>
    <script>
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
          ['insert', ['link', 'picture', 'video']], // Fitur Insert Gambar & Video
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    </script>
</x-app-layout>