<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $data = [
                'totalSiswa' => User::where('role', 'siswa')->count(),
                'totalGuru' => User::where('role', 'guru')->count(),
                'totalKelas' => Course::count(), // Mengambil total kelas dari database
                'latestUsers' => User::latest()->take(5)->get(),
            ];

            return view('dashboard', $data);
        } elseif ($user->role == 'guru') {
            // Nanti kita isi logika guru di sini
            return view('dashboard');
        } elseif ($user->role == 'siswa') {
            // LANGSUNG LEMPAR KE RUTE STUDENT! (Satu pintu)
            return view('dashboard');
        }

        return view('dashboard');
    }
}
