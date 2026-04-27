<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query Dasar: Hanya Guru dan Siswa
        $query = User::whereIn('role', ['guru', 'siswa']);

        // 1. Logic Search (Nama atau Email)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // 2. Logic Filter Role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:guru,siswa',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            // Set password otomatis ke "siswa123"
            'password' => bcrypt('siswa123'),
        ]);

        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat dengan password default: siswa123');
    }

    // Fungsi untuk proses upload file excel

    // Fungsi untuk download template excel/csv kosong
    // Fungsi untuk download template excel (.xlsx)
    public function downloadTemplate()
    {
        // Bersihkan output buffer agar file tidak rusak (corrupt/blank page)
        if (ob_get_length()) {
            ob_end_clean();
        }

        // Siapkan data template
        $data = [
            ['Nama Lengkap', 'Email', 'Role (guru/siswa)'], // Baris 1 (Header)
            ['Budi Santoso', 'budi@sekolah.com', 'siswa'],  // Baris 2
            ['Siti Aminah', 'siti@sekolah.com', 'guru'],    // Baris 3
        ];

        // Buat file dan langsung eksekusi download
        SimpleXLSXGen::fromArray($data)->downloadAs('Template_Import_Akun.xlsx');
        exit;
    }

    // 2. Fungsi untuk memproses data Excel yang di-upload
    public function import(Request $request)
    {
        // Validasi file yang diupload wajib excel
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $filePath = $request->file('file')->getRealPath();

        // Baca file menggunakan SimpleXLSX
        if ($xlsx = SimpleXLSX::parse($filePath)) {
            $rows = $xlsx->rows();

            // Hapus baris pertama (Header) agar tidak ikut tersimpan ke database
            unset($rows[0]);

            foreach ($rows as $row) {
                // Mapping berdasarkan urutan kolom: [0] = Nama, [1] = Email, [2] = Role
                $nama = $row[0] ?? null;
                $email = $row[1] ?? null;
                $role = isset($row[2]) ? strtolower($row[2]) : 'siswa';

                // Simpan jika nama & email tidak kosong, dan email belum dipakai
                if ($nama && $email && ! User::where('email', $email)->exists()) {
                    User::create([
                        'name' => $nama,
                        'email' => $email,
                        'role' => $role,
                        'password' => Hash::make('siswa123'), // Default Password!
                    ]);
                }
            }

            return redirect()->route('users.index')->with('success', 'Data siswa berhasil di-import secara massal!');
        } else {
            return redirect()->route('users.index')->with('error', 'Gagal membaca file Excel. Pastikan formatnya adalah .xlsx');
        }
    }

    // Fungsi untuk memproses data Excel yang di-upload

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Cegah edit akun admin
        if ($user->role === 'admin') {
            return redirect()->route('users.index')->with('error', 'Tidak dapat mengedit akun admin!');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Cegah update akun admin
            if ($user->role === 'admin') {
                return redirect()->route('users.index')->with('error', 'Tidak dapat mengubah akun admin!');
            }

            // Validasi
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'role' => ['required', 'in:guru,siswa'],
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            ]);

            // Update data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui akun. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Cegah hapus akun admin
            if ($user->role === 'admin') {
                return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun admin!');
            }

            $user->delete();

            return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Gagal menghapus akun. Silakan coba lagi.');
        }
    }
}
