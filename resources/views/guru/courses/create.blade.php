<x-app-layout>
    <div class="relative bg-gradient-to-br from-teal-500 via-cyan-600 to-blue-600 py-12">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('courses.index') }}" class="p-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h1 class="text-3xl font-bold text-white">Buat Kelas Baru</h1>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-12 relative z-10">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all" placeholder="Contoh: Pemrograman Web Dasar" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all" placeholder="Jelaskan apa yang akan dipelajari di kelas ini..." required></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('courses.index') }}" class="px-6 py-3 rounded-xl text-gray-600 font-bold hover:bg-gray-100 transition-all border-2 border-gray-200">Batal</a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">Simpan Kelas</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>