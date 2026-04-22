<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung data untuk statistik
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalKelas = Course::count(); // Pastikan model Course sudah ada

        return view('dashboard', compact('totalSiswa', 'totalGuru', 'totalKelas'));
    }
}
