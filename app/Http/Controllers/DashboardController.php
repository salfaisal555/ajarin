<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. MERANGKUM DATA UNTUK ADMIN
        if ($user->role == 'admin') {
            $data = [
                'totalSiswa' => User::where('role', 'siswa')->count(),
                'totalGuru' => User::where('role', 'guru')->count(),
                'totalKelas' => 0, // Nanti diganti dengan hitungan tabel Kelas
                'latestUsers' => User::latest()->take(5)->get(),
            ];

            return view('dashboard', $data);
        }

        // 2. MERANGKUM DATA UNTUK SISWA
        elseif ($user->role == 'siswa') {
            $data = [
                // Contoh logika: mengambil data yang BERHUBUNGAN dengan siswa tersebut saja
                'totalKelasSiswa' => 0, // Nanti diganti misal: $user->courses()->count()
                'tugasAktif' => 0, // Nanti diganti misal: Tugas::where('status', 'pending')->count()
                'poinBelajar' => 0,
            ];

            return view('dashboard', $data);
        }

        // 3. MERANGKUM DATA UNTUK GURU
        elseif ($user->role == 'guru') {
            $data = [
                'kelasDiampu' => 0, // Nanti diganti dengan total kelas milik guru ini
            ];

            return view('dashboard', $data);
        }

        // Jika tidak masuk kondisi apa pun
        return view('dashboard');
    }
}
