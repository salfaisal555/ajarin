<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tangkap semua form di halaman
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    
                    // Jangan eksekusi jika validasi bawaan HTML (required) gagal
                    if (!form.checkValidity()) return;

                    // Cari tombol submit di dalam form ini
                    const btn = form.querySelector('button[type="submit"]');
                    
                    if (btn) {
                        // Cegah double-klik
                        if (form.dataset.submitted === 'true') {
                            e.preventDefault();
                            return;
                        }
                        form.dataset.submitted = 'true';

                        // Simpan lebar tombol agar tidak mengecil saat teksnya ganti
                        const originalWidth = btn.offsetWidth;
                        btn.style.width = originalWidth + 'px';
                        
                        // Disable tombol dan ubah tampilannya
                        btn.disabled = true;
                        btn.classList.add('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
                        
                        // Ganti isi tombol dengan icon spinner Tailwind dan teks "Memproses"
                        btn.innerHTML = `
                            <div class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-current opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </div>
                        `;
                    }
                });
            });
        });
    </script>
    </body>
</html>
