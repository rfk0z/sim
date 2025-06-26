<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardDosenController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 1)->count();
        $dosenCount = User::where('role', 2)->count();
        $mahasiswaCount = User::where('role', 3)->count();

        return view('dosen.dashboard', [
            'title' => 'Dashboard Dosen',
            'statistik_pengguna' => [
                'total' => $totalUsers,
                'admin' => $adminCount,
                'dosen' => $dosenCount,
                'mahasiswa' => $mahasiswaCount,
            ],
        ]);
    }
}
