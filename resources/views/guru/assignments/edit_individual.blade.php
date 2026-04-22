<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Edit Ujian Individual</h1>
            <a href="{{ route('courses.show', $course->id) }}" class="text-gray-500 hover:text-gray-700 font-bold">&larr; Batal</a>
        </div>

        <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" id="ujianForm">
            @csrf @method('PUT')
            <div class="bg-white p-6 rounded-xl shadow-md mb-6 border-t-4 border-blue-500">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Ujian</label>
                        <input type="text" name="title" value="{{ $assignment->title }}" class="w-full rounded-lg border-gray-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Batas Waktu</label>
                        <input type="datetime-local" name="deadline" value="{{ \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d\TH:i') }}" class="w-full rounded-lg border-gray-300" required>
                    </div>
                </div>
            </div>

            <div id="questionsContainer" class="space-y-6">
                @foreach($assignment->questions as $index => $q)
                    <div class="question-item bg-white p-6 rounded-xl shadow-md border border-gray-100 relative">
                        <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $q->id }}">
                        <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-red-500 text-sm font-bold">Hapus</button>
                        <h3 class="font-bold text-lg text-blue-800 mb-4 pb-2 border-b">Soal {{ $index + 1 }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan</label>
                            <textarea name="questions[{{ $index }}][question]" rows="2" class="w-full rounded-lg border-gray-300" required>{{ $q->question }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div><label class="text-xs font-bold text-gray-500">Opsi A</label><input type="text" name="questions[{{ $index }}][option_a]" value="{{ $q->option_a }}" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                            <div><label class="text-xs font-bold text-gray-500">Opsi B</label><input type="text" name="questions[{{ $index }}][option_b]" value="{{ $q->option_b }}" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                            <div><label class="text-xs font-bold text-gray-500">Opsi C</label><input type="text" name="questions[{{ $index }}][option_c]" value="{{ $q->option_c }}" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                            <div><label class="text-xs font-bold text-gray-500">Opsi D</label><input type="text" name="questions[{{ $index }}][option_d]" value="{{ $q->option_d }}" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kunci Jawaban</label>
                            <select name="questions[{{ $index }}][correct_answer]" class="w-full md:w-1/3 rounded-lg border-gray-300" required>
                                <option value="a" {{ $q->correct_answer == 'a' ? 'selected' : '' }}>Opsi A</option>
                                <option value="b" {{ $q->correct_answer == 'b' ? 'selected' : '' }}>Opsi B</option>
                                <option value="c" {{ $q->correct_answer == 'c' ? 'selected' : '' }}>Opsi C</option>
                                <option value="d" {{ $q->correct_answer == 'd' ? 'selected' : '' }}>Opsi D</option>
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-between">
                <button type="button" onclick="addQuestion()" class="px-6 py-2 border-2 border-blue-500 text-blue-600 font-bold rounded-xl">+ Tambah Soal</button>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl">Update Ujian</button>
            </div>
        </form>
    </div>

    <script>
        let qIndex = {{ $assignment->questions->count() }};
        function addQuestion() {
            const container = document.getElementById('questionsContainer');
            const html = `
                <div class="question-item bg-white p-6 rounded-xl shadow-md border border-gray-100 relative mt-6">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-red-500 text-sm font-bold">Hapus</button>
                    <h3 class="font-bold text-lg text-blue-800 mb-4 pb-2 border-b">Soal Baru</h3>
                    <div class="mb-4"><label class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan</label><textarea name="questions[${qIndex}][question]" rows="2" class="w-full rounded-lg border-gray-300" required></textarea></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div><label class="text-xs font-bold text-gray-500">Opsi A</label><input type="text" name="questions[${qIndex}][option_a]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                        <div><label class="text-xs font-bold text-gray-500">Opsi B</label><input type="text" name="questions[${qIndex}][option_b]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                        <div><label class="text-xs font-bold text-gray-500">Opsi C</label><input type="text" name="questions[${qIndex}][option_c]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                        <div><label class="text-xs font-bold text-gray-500">Opsi D</label><input type="text" name="questions[${qIndex}][option_d]" class="w-full rounded-lg border-gray-300 text-sm" required></div>
                    </div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Kunci Jawaban</label><select name="questions[${qIndex}][correct_answer]" class="w-full md:w-1/3 rounded-lg border-gray-300"><option value="a">A</option><option value="b">B</option><option value="c">C</option><option value="d">D</option></select></div>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            qIndex++;
        }
    </script>
</x-app-layout>