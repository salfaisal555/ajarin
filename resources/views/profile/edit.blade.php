<x-app-layout>
    <div class="bg-gradient-to-br from-teal-500 via-cyan-600 to-blue-600 pb-24 pt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-6">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-white flex items-center justify-center shadow-xl text-teal-600 text-4xl font-black uppercase">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mb-1">{{ Auth::user()->name }}</h1>
                <div class="flex items-center gap-2 text-cyan-100 text-sm sm:text-base font-medium">
                    <span class="px-3 py-1 bg-white/20 rounded-full backdrop-blur-sm uppercase text-[10px] font-black tracking-wider">
                        {{ Auth::user()->role == 'admin' ? 'Administrator' : (Auth::user()->role == 'guru' ? 'Guru Pengajar' : 'Siswa') }}
                    </span>
                    <span>&bull; {{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 pb-12">
        <div class="grid grid-cols-1 gap-8">
            
            <div class="p-6 sm:p-10 bg-white shadow-2xl shadow-gray-200/50 rounded-[2rem] border border-gray-100">
                <div class="max-w-xl">
                    <h2 class="text-xl font-bold text-gray-800 mb-1">Informasi Profil</h2>
                    <p class="text-sm text-gray-500 mb-6">Perbarui nama dan alamat email akun Anda.</p>
                    
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" value="Nama Lengkap" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Alamat Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition">Simpan Perubahan</button>
                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-emerald-600 font-medium">Tersimpan.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-2xl shadow-gray-200/50 rounded-[2rem] border border-gray-100">
                <div class="max-w-xl">
                    <h2 class="text-xl font-bold text-gray-800 mb-1">Keamanan Akun</h2>
                    <p class="text-sm text-gray-500 mb-6">Pastikan Anda menggunakan kata sandi yang kuat agar tetap aman.</p>
                    
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="update_password_current_password" value="Kata Sandi Saat Ini" />
                            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="update_password_password" value="Kata Sandi Baru" />
                            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="update_password_password_confirmation" value="Konfirmasi Kata Sandi Baru" />
                            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition">Perbarui Kata Sandi</button>
                            @if (session('status') === 'password-updated')
                                <p class="text-sm text-emerald-600 font-medium">Tersimpan.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-2xl shadow-gray-200/50 rounded-[2rem] border border-red-100 border-l-8 border-l-red-500">
                <div class="max-w-xl">
                    <h2 class="text-xl font-bold text-red-600 mb-1">Hapus Akun</h2>
                    <p class="text-sm text-gray-500 mb-6">Setelah akun dihapus, semua data dan riwayat belajar Anda akan hilang permanen.</p>
                    
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition">
                        Hapus Akun Saya
                    </button>

                    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-bold text-gray-900">Apakah Anda yakin ingin menghapus akun ini?</h2>
                            <p class="mt-1 text-sm text-gray-600">Masukkan kata sandi Anda untuk mengonfirmasi penghapusan secara permanen.</p>

                            <div class="mt-6">
                                <x-input-label for="password" value="Kata Sandi" class="sr-only" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="Kata Sandi Anda" />
                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button x-on:click="$dispatch('close')" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition mr-3">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition">Ya, Hapus Akun</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>