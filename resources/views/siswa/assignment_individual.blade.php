<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
            
            <a href="{{ route('student.corridor', $course->id) }}" class="text-teal-600 font-bold hover:underline mb-6 inline-block">&larr; Kembali ke Koridor</a>

            @if($scoreRecord)
                <div class="bg-white rounded-3xl shadow-lg border border-teal-100 p-10 text-center mt-8">
                    <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800 mb-2">Ujian Telah Diselesaikan</h2>
                    <p class="text-gray-500 mb-6">Anda sudah mengumpulkan jawaban untuk evaluasi ini.</p>
                    
                    <div class="bg-teal-50 border border-teal-100 rounded-2xl p-6 inline-block min-w-[200px]">
                        <p class="text-sm font-bold text-teal-800 uppercase tracking-wider mb-1">Nilai Anda</p>
                        <p class="text-6xl font-black text-teal-600">{{ $scoreRecord->score }}</p>
                    </div>
                </div>

            @else
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 mb-8 flex justify-between items-center border-l-4 border-l-teal-500">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $assignment->title }}</h1>
                        <p class="text-gray-500 text-sm">Kerjakan soal-soal di bawah ini dengan teliti. Anda hanya memiliki satu kali kesempatan.</p>
                    </div>
                    <div class="text-right bg-red-50 p-3 rounded-xl border border-red-100">
                        <p class="text-xs font-bold text-red-400 uppercase tracking-wider mb-1">Batas Waktu</p>
                        <p class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <form action="{{ route('student.assignment.submit', $assignment->id) }}" method="POST" id="formUjian">
                    @csrf
                    <div class="space-y-6">
                        @foreach($questions as $index => $q)
                            <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8 border border-gray-100 transition-all hover:shadow-md">
                                <p class="font-bold text-gray-800 mb-5 text-lg leading-relaxed">
                                    <span class="text-teal-600 mr-1">{{ $index + 1 }}.</span> {{ $q->question }}
                                </p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="flex items-center p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-teal-50 hover:border-teal-300 transition-all has-[:checked]:bg-teal-50 has-[:checked]:border-teal-500">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="a" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500" required>
                                        <span class="ml-3 text-gray-700 font-medium leading-tight">{{ $q->option_a }}</span>
                                    </label>
                                    
                                    <label class="flex items-center p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-teal-50 hover:border-teal-300 transition-all has-[:checked]:bg-teal-50 has-[:checked]:border-teal-500">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="b" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500" required>
                                        <span class="ml-3 text-gray-700 font-medium leading-tight">{{ $q->option_b }}</span>
                                    </label>
                                    
                                    <label class="flex items-center p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-teal-50 hover:border-teal-300 transition-all has-[:checked]:bg-teal-50 has-[:checked]:border-teal-500">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="c" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500" required>
                                        <span class="ml-3 text-gray-700 font-medium leading-tight">{{ $q->option_c }}</span>
                                    </label>
                                    
                                    <label class="flex items-center p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-teal-50 hover:border-teal-300 transition-all has-[:checked]:bg-teal-50 has-[:checked]:border-teal-500">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="d" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500" required>
                                        <span class="ml-3 text-gray-700 font-medium leading-tight">{{ $q->option_d }}</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 text-right bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                        <p class="text-sm text-gray-500">Pastikan semua soal telah terjawab.</p>
                        <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-lg hover:bg-teal-700 transition transform hover:-translate-y-0.5" onclick="return confirm('Yakin ingin mengumpulkan jawaban? Anda tidak dapat mengubahnya lagi nanti.')">
                            Kumpulkan Jawaban
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>