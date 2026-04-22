<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Buat Ujian Individual</h1>
                <p class="text-gray-500">Kelas: {{ $course->title }}</p>
            </div>
            <a href="{{ route('courses.show', $course->id) }}" class="text-gray-500 hover:text-gray-700 font-bold">&larr; Batal</a>
        </div>

        <form action="{{ route('assignments.store_individual', $course->id) }}" method="POST" id="ujianForm">
            @csrf
            <div class="bg-white p-6 rounded-xl shadow-md mb-6 border-t-4 border-blue-500">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Ujian</label>
                        <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required placeholder="Contoh: Kuis Bab 1">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Batas Waktu (Deadline)</label>
                        <input type="datetime-local" name="deadline" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required>
                    </div>
                </div>
            </div>

            <div id="questionsContainer" class="space-y-6">
                <div class="question-item bg-white p-6 rounded-xl shadow-md border border-gray-100 relative">
                    <h3 class="font-bold text-lg text-blue-800 mb-4 pb-2 border-b border-gray-100">Soal <span class="q-number">1</span></h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan</label>
                        <textarea name="questions[0][question]" rows="2" class="w-full rounded-lg border-gray-300" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500">Opsi A</label>
                            <input type="text" name="questions[0][option_a]" class="w-full rounded-lg border-gray-300 text-sm" required>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500">Opsi B</label>
                            <input type="text" name="questions[0][option_b]" class="w-full rounded-lg border-gray-300 text-sm" required>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500">Opsi C</label>
                            <input type="text" name="questions[0][option_c]" class="w-full rounded-lg border-gray-300 text-sm" required>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500">Opsi D</label>
                            <input type="text" name="questions[0][option_d]" class="w-full rounded-lg border-gray-300 text-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kunci Jawaban Benar</label>
                        <select name="questions[0][correct_answer]" class="w-full md:w-1/3 rounded-lg border-gray-300 bg-blue-50" required>
                            <option value="a">Opsi A</option>
                            <option value="b">Opsi B</option>
                            <option value="c">Opsi C</option>
                            <option value="d">Opsi D</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <button type="button" onclick="addQuestion()" class="px-6 py-2 border-2 border-blue-500 text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition">
                    + Tambah Soal
                </button>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg">
                    Simpan Ujian
                </button>
            </div>
        </form>
    </div>

    <script>
        let qIndex = 1;
        function addQuestion() {
            const container = document.getElementById('questionsContainer');
            const html = `
                <div class="question-item bg-white p-6 rounded-xl shadow-md border border-gray-100 relative mt-6">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold text-sm">Hapus Soal</button>
                    <h3 class="font-bold text-lg text-blue-800 mb-4 pb-2 border-b border-gray-100">Soal Baru</h3>
                    
                    <div class="mb-4"><label class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan</label><textarea name="questions[${qIndex}][question]" rows="2" class="w-full rounded-lg border-gray-300" required></textarea></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div><label class="text-xs font-bold text-gray-500">Opsi A</label><input type="text" name="questions[${qIndex}][option_a]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                        <div><label class="text-xs font-bold text-gray-500">Opsi B</label><input type="text" name="questions[${qIndex}][option_b]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                        <div><label class="text-xs font-bold text-gray-500">Opsi C</label><input type="text" name="questions[${qIndex}][option_c]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                        <div><label class="text-xs font-bold text-gray-500">Opsi D</label><input type="text" name="questions[${qIndex}][option_d]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kunci Jawaban Benar</label>
                        <select name="questions[${qIndex}][correct_answer]" class="w-full md:w-1/3 rounded-lg border-gray-300 bg-blue-50" required>
                            <option value="a">Opsi A</option><option value="b">Opsi B</option><option value="c">Opsi C</option><option value="d">Opsi D</option>
                        </select>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            qIndex++;
        }
    </script>
</x-app-layout>