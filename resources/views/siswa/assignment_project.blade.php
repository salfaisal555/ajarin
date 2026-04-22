<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
            
            <a href="{{ route('student.corridor', $course->id) }}" class="text-teal-600 font-bold hover:underline mb-6 inline-block">&larr; Kembali ke Koridor</a>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-1">Proyek Kelompok</div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $assignment->title }}</h1>
                        <p class="text-sm text-red-500 font-bold mb-8">Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}</p>

                        <div class="prose prose-teal max-w-none text-gray-700">
                            {!! $assignment->description !!}
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    @if($myGroup)
                        <div class="bg-indigo-50 rounded-2xl shadow-sm p-6 border border-indigo-100">
                            <h2 class="text-xl font-bold text-indigo-900 mb-4">👥 {{ $myGroup->name }}</h2>
                            <h3 class="text-xs font-bold text-indigo-400 uppercase tracking-wider mb-2">Anggota Kelompok:</h3>
                            <ul class="space-y-2 mb-6">
                                @foreach($myGroup->members as $member)
                                    <li class="flex items-center text-sm font-medium text-indigo-800">
                                        <span class="w-2 h-2 bg-indigo-400 rounded-full mr-2"></span>
                                        {{ $member->name }} {{ $member->id == Auth::id() ? '(Anda)' : '' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                Pengumpulan Link
                            </h3>
                            
                            <form action="{{ route('student.project.links', $myGroup->id) }}" method="POST" class="space-y-4">
                                @csrf @method('PUT')
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Link Monitoring (Google Drive/Trello/dll)</label>
                                    <input type="url" name="monitoring_link" value="{{ $myGroup->monitoring_link }}" class="w-full text-sm rounded-lg border-gray-300 focus:ring-teal-500" placeholder="https://...">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Link Final (Hasil Akhir)</label>
                                    <input type="url" name="final_link" value="{{ $myGroup->final_link }}" class="w-full text-sm rounded-lg border-gray-300 focus:ring-teal-500" placeholder="https://...">
                                </div>
                                <button type="submit" class="w-full py-2.5 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition">
                                    Simpan Link
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-red-50 text-red-700 p-6 rounded-2xl border border-red-200">
                            <p class="font-bold">Anda belum dimasukkan ke kelompok manapun.</p>
                            <p class="text-sm mt-2">Silakan hubungi Guru Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>