<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat', 'pengembalian.denda']);

        if ($request->filled('dari')) {
            $query->whereDate('tgl_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tgl_pinjam', '<=', $request->sampai);
        }
        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }

        $peminjamans  = $query->latest()->get();
        $totalDenda   = Pengembalian::sum('denda');

        return view('petugas.laporan', compact('peminjamans', 'totalDenda'));
    }

    public function cetak(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat', 'pengembalian.denda']);

        if ($request->filled('dari')) {
            $query->whereDate('tgl_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tgl_pinjam', '<=', $request->sampai);
        }

        $peminjamans = $query->latest()->get();
        $totalDenda  = $peminjamans->sum(fn($p) => optional($p->pengembalian)->denda ?? 0);

        return view('petugas.laporan_cetak', compact('peminjamans', 'totalDenda'));
    }
}
