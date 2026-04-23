<x-app-layout>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <div class="relative bg-gradient-to-br from-teal-500 via-cyan-600 to-blue-600 overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Kelola Akun</h1>
                    <p class="text-white/90 text-base sm:text-lg">Manajemen data Guru dan Siswa</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="openImportModal()" class="inline-flex items-center px-4 sm:px-5 py-2.5 sm:py-3 bg-emerald-500 text-white font-bold rounded-xl shadow-lg hover:bg-emerald-600 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Import Excel
                    </button>

                    <button type="button" onclick="openAddModal()" class="inline-flex items-center px-4 sm:px-5 py-2.5 sm:py-3 bg-white text-teal-600 font-bold rounded-xl shadow-lg hover:bg-teal-50 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Manual
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-12 relative z-10">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <div class="p-4 sm:p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <form method="GET" action="{{ route('users.index') }}" class="flex flex-col lg:flex-row gap-3 sm:gap-4">
                    
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-shadow bg-white shadow-sm" 
                               placeholder="Cari nama atau email...">
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative w-full sm:w-48" id="customDropdown">
                            <input type="hidden" name="role" id="roleInput" value="{{ request('role') }}">
                            <button type="button" onclick="toggleDropdown()" id="dropdownButton" class="w-full flex justify-between items-center py-2.5 px-4 rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm focus:outline-none focus:border-teal-500 focus:ring focus:ring-teal-200 transition-all duration-200 font-medium">
                                <span id="dropdownText">
                                    @if(request('role') == 'guru') Guru
                                    @elseif(request('role') == 'siswa') Siswa
                                    @else Semua Role
                                    @endif
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" id="dropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div id="dropdownMenu" class="absolute z-20 hidden w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 transform opacity-0 scale-95 transition-all duration-200 origin-top">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li>
                                        <button type="button" onclick="selectRole('', 'Semua Role')" class="w-full text-left px-4 py-2 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('role') == '' ? 'bg-teal-50 text-teal-700 font-bold' : '' }}">
                                            Semua Role
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" onclick="selectRole('guru', 'Guru')" class="w-full text-left px-4 py-2 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('role') == 'guru' ? 'bg-teal-50 text-teal-700 font-bold' : '' }}">
                                            Guru
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" onclick="selectRole('siswa', 'Siswa')" class="w-full text-left px-4 py-2 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('role') == 'siswa' ? 'bg-teal-50 text-teal-700 font-bold' : '' }}">
                                            Siswa
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-xl font-medium shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </span>
                        </button>
                        
                        @if(request('search') || request('role'))
                            <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-medium hover:bg-gray-200 transition text-center flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">User Info</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Status</th>
                            <th class="px-4 sm:px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-gradient-to-r hover:from-teal-50/30 hover:to-cyan-50/30 transition-all duration-200">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 sm:h-12 sm:w-12">
                                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white font-bold text-base sm:text-lg shadow-lg">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-3 sm:ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs sm:text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if($user->role == 'guru')
                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 border border-blue-200 shadow-sm">Guru</span>
                                @else
                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-teal-100 to-teal-50 text-teal-800 border border-teal-200 shadow-sm">Siswa</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="flex items-center text-sm text-teal-600 font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-teal-500 mr-2 animate-pulse shadow-lg shadow-teal-500/50"></span>
                                    Aktif
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" 
                                        data-id="{{ $user->id }}" 
                                        data-name="{{ $user->name }}" 
                                        data-email="{{ $user->email }}" 
                                        data-role="{{ $user->role }}" 
                                        onclick="openEditModal(this)" 
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="hidden sm:inline">Edit</span>
                                    </button>
                                    
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <p>Tidak ada data ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->count() > 0)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-teal-600">{{ $users->count() }}</span> data
                </p>
            </div>
            @endif
        </div>
    </div>

    <div id="modalAddUser" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Tambah Akun Baru</h3>
                <button type="button" onclick="closeAddModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="p-6 space-y-4">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <p class="text-sm text-blue-700 font-medium">
                                Password akun baru otomatis di-set ke: <br>
                                <strong class="text-lg tracking-widest text-blue-900">siswa123</strong>
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200" placeholder="email@contoh.com" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role</label>
                        <select name="role" class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200" required>
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                        </select>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition shadow-md">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalImportExcel" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Import Data via Excel</h3>
                <button type="button" onclick="closeImportModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('users.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-600 mb-4">
                        Unggah file Excel (<strong>.xlsx</strong>) yang berisi daftar siswa. Semua akun otomatis menggunakan password <strong>siswa123</strong>.
                    </p>
                    
                    <a href="{{ route('users.download_template') }}" class="inline-block mb-4 text-teal-600 font-bold text-sm hover:underline">
                        &darr; Download Template Excel
                    </a>

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:bg-gray-50 transition cursor-pointer" onclick="document.getElementById('fileExcel').click()">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="mt-2 text-sm font-medium text-gray-900">Klik untuk memilih file Excel</p>
                        <p class="mt-1 text-xs text-gray-500" id="fileNameDisplay">Belum ada file dipilih</p>
                        <input type="file" id="fileExcel" name="file" accept=".xlsx, .xls" class="hidden" required onchange="document.getElementById('fileNameDisplay').innerText = this.files[0].name">
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white font-bold rounded-lg hover:bg-emerald-600 transition shadow-md">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditUser" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Edit Akun</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form id="editUserForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="edit_name" name="name" class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-shadow" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" id="edit_email" name="email" class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-shadow" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role</label>
                        <select id="edit_role" name="role" class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-shadow" required>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="password" name="password" class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition-shadow" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Notifikasi Toast
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                background: '#f0fdfa',
                iconColor: '#14b8a6',
                customClass: { popup: 'rounded-xl shadow-2xl' }
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                customClass: { popup: 'rounded-xl shadow-2xl' }
            });
        @endif

        // Konfirmasi Hapus
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus akun<br><strong class="text-teal-600">${userName}</strong>?<br><small class="text-gray-500">Tindakan ini tidak dapat dibatalkan!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#ef4444',
                confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    confirmButton: 'rounded-lg px-6 py-3 font-bold',
                    cancelButton: 'rounded-lg px-6 py-3 font-bold'
                },
                buttonsStyling: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }

        // Fungsi Buka/Tutup Modal Tambah
        function openAddModal() {
            document.getElementById('modalAddUser').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('modalAddUser').classList.add('hidden');
        }

        // Fungsi Buka/Tutup Modal Edit
        function openEditModal(button) {
            let id = button.getAttribute('data-id');
            let name = button.getAttribute('data-name');
            let email = button.getAttribute('data-email');
            let role = button.getAttribute('data-role');

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;

            let urlTemplate = "{{ route('users.update', ':id') }}";
            document.getElementById('editUserForm').action = urlTemplate.replace(':id', id);

            document.getElementById('modalEditUser').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('modalEditUser').classList.add('hidden');
        }

        // Script Custom Dropdown
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            const arrow = document.getElementById('dropdownArrow');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('opacity-0', 'scale-95');
                    menu.classList.add('opacity-100', 'scale-100');
                    arrow.classList.add('rotate-180');
                }, 10);
            } else {
                closeDropdown();
            }
        }

        function closeDropdown() {
            const menu = document.getElementById('dropdownMenu');
            const arrow = document.getElementById('dropdownArrow');

            menu.classList.remove('opacity-100', 'scale-100');
            menu.classList.add('opacity-0', 'scale-95');
            arrow.classList.remove('rotate-180');

            setTimeout(() => {
                menu.classList.add('hidden');
            }, 200);
        }

        function selectRole(value, text) {
            document.getElementById('roleInput').value = value;
            document.getElementById('dropdownText').innerText = text;
            closeDropdown();
        }

        // Event Listener Global (Klik di luar dropdown / modal)
        document.addEventListener('click', function(event) {
            // Tutup dropdown
            const dropdown = document.getElementById('customDropdown');
            const menu = document.getElementById('dropdownMenu');
            if (dropdown && !dropdown.contains(event.target) && !menu.classList.contains('hidden')) {
                closeDropdown();
            }

            // Tutup modal jika klik di luar area putih modal
            let addModal = document.getElementById('modalAddUser');
            let editModal = document.getElementById('modalEditUser');
            if (event.target == addModal) closeAddModal();
            if (event.target == editModal) closeEditModal();
        });
        function openImportModal() {
            document.getElementById('modalImportExcel').classList.remove('hidden');
        }
        function closeImportModal() {
            document.getElementById('modalImportExcel').classList.add('hidden');
            document.getElementById('fileExcel').value = ""; // Reset file input
            document.getElementById('fileNameDisplay').innerText = "Belum ada file dipilih";
        }
    </script>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</x-app-layout>