<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
            <input id="name" name="name" type="text"
                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 bg-gray-50 hover:bg-white transition-all"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<p class="text-red-500 text-xs font-bold mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
            <input id="email" name="email" type="email"
                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 bg-gray-50 hover:bg-white transition-all"
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<p class="text-red-500 text-xs font-bold mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-amber-50 border border-amber-200 rounded-xl p-3">
                    <p class="text-sm text-amber-800 font-medium">
                        Email Anda belum terverifikasi.
                        <button form="send-verification" class="underline font-bold text-amber-700 hover:text-amber-900 ml-1">
                            Kirim ulang email verifikasi
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-sm text-emerald-600">Tautan verifikasi baru telah dikirim!</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-bold rounded-xl hover:from-teal-600 hover:to-cyan-700 transition-all shadow-md hover:shadow-lg active:scale-95">
                Simpan Perubahan
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-bold text-emerald-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Berhasil disimpan!
                </p>
            @endif
        </div>
    </form>
</section>
