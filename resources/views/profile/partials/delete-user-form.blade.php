<section class="space-y-4">
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-5 py-2.5 bg-red-50 border border-red-200 text-red-700 font-bold rounded-xl hover:bg-red-100 hover:border-red-300 transition-all duration-200 text-sm">
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-start gap-4 mb-5">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Hapus Akun?</h2>
                    <p class="mt-1 text-sm text-gray-500 leading-relaxed">Tindakan ini tidak dapat dibatalkan. Semua data, materi, dan riwayat belajar Anda akan dihapus secara permanen.</p>
                </div>
            </div>

            <div class="mb-5">
                <label for="del_password" class="block text-sm font-bold text-gray-700 mb-2">Masukkan kata sandi untuk konfirmasi</label>
                <input id="del_password" name="password" type="password"
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-red-400 focus:ring-4 focus:ring-red-100 bg-gray-50 transition-all"
                       placeholder="Kata sandi Anda">
                @if($errors->userDeletion->get('password'))
                    <p class="text-red-500 text-xs font-bold mt-1.5">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 active:scale-95 transition-all text-sm shadow-md">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
