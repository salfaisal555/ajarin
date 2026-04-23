<x-app-layout>
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-3xl shadow-xl border-t-8 border-rose-500">
            
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-100 mb-4">
                    <svg class="h-8 w-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900">Keamanan Akun</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Anda masih menggunakan password bawaan sistem (<span class="font-bold text-rose-600">siswa123</span>). Demi keamanan, Anda <strong>wajib menggantinya</strong> sebelum bisa mengakses kelas.
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('password.force_update') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru</label>
                        <input name="password" type="password" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ulangi Password Baru</label>
                        <input name="password_confirmation" type="password" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm" placeholder="Ketik ulang password baru">
                    </div>
                </div>

                @if($errors->any())
                    <div class="text-red-500 text-sm text-center font-medium">{{ $errors->first() }}</div>
                @endif

                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-all shadow-md hover:shadow-lg">
                    Simpan Password & Masuk
                </button>
            </form>
            
            <div class="text-center mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-800 underline">Nanti saja (Keluar)</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>