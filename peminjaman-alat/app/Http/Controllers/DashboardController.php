<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $data = [
                'total_alat'       => Alat::count(),
                'total_user'       => User::count(),
                'total_peminjaman' => Peminjaman::count(),
                'menunggu'         => Peminjaman::where('status_peminjaman', 'menunggu')->count(),
            ];
            return view('dashboard.admin', compact('data'));
        }

        if ($user->isPetugas()) {
            $data = [
                'menunggu'    => Peminjaman::where('status_peminjaman', 'menunggu')->count(),
                'disetujui'   => Peminjaman::where('status_peminjaman', 'disetujui')->count(),
                'dikembalikan'=> Peminjaman::where('status_peminjaman', 'dikembalikan')->count(),
            ];
            return view('dashboard.petugas', compact('data'));
        }

        // peminjam
        $data = [
            'peminjaman_aktif' => Peminjaman::where('user_id', $user->id)
                ->whereIn('status_peminjaman', ['menunggu', 'disetujui'])->count(),
            'riwayat'          => Peminjaman::where('user_id', $user->id)->count(),
        ];
        return view('dashboard.peminjam', compact('data'));
    }
}
