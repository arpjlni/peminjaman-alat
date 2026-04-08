<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    const TARIF_DENDA = 5000; // Rp 5.000 per hari

    // Admin: CRUD pengembalian
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.alat', 'denda'])->latest()->paginate(10);
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    // Petugas: pantau pengembalian
    public function pantau()
    {
        $peminjamans = Peminjaman::with(['user', 'alat', 'pengembalian'])
            ->where('status_peminjaman', 'disetujui')
            ->latest()->paginate(10);
        return view('petugas.pengembalian', compact('peminjamans'));
    }

    // Peminjam: form kembalikan alat
    public function formKembali(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status_peminjaman !== 'disetujui') {
            abort(403);
        }
        return view('peminjam.kembali', compact('peminjaman'));
    }

    public function prosesPengembalian(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status_peminjaman !== 'disetujui') {
            abort(403);
        }

        $request->validate([
            'tgl_pengembalian' => 'required|date',
            'kondisi_alat'     => 'required|in:baik,rusak,perbaikan',
        ]);

        $tglKembali      = $peminjaman->tgl_kembali;
        $tglPengembalian = \Carbon\Carbon::parse($request->tgl_pengembalian);
        $hariTerlambat   = max(0, $tglKembali->diffInDays($tglPengembalian, false));
        $totalDenda      = $hariTerlambat > 0 ? $hariTerlambat * self::TARIF_DENDA : 0;

        $pengembalian = Pengembalian::create([
            'peminjaman_id'    => $peminjaman->id,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'kondisi_alat'     => $request->kondisi_alat,
            'denda'            => $totalDenda,
        ]);

        if ($hariTerlambat > 0) {
            Denda::create([
                'pengembalian_id' => $pengembalian->id,
                'hari_terlambat'  => $hariTerlambat,
                'total_denda'     => $totalDenda,
            ]);
        }

        $peminjaman->update(['status_peminjaman' => 'dikembalikan']);
        $peminjaman->alat->update([
            'status'  => 'tersedia',
            'kondisi' => $request->kondisi_alat,
        ]);

        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => 'Mengembalikan alat: ' . $peminjaman->alat->nama_alat .
                ($hariTerlambat > 0 ? " (terlambat {$hariTerlambat} hari, denda Rp " . number_format($totalDenda, 0, ',', '.') . ")" : ''),
            'waktu'     => now(),
        ]);

        return redirect()->route('peminjam.riwayat')->with('success', 'Pengembalian berhasil.' .
            ($hariTerlambat > 0 ? " Denda: Rp " . number_format($totalDenda, 0, ',', '.') : ' Tidak ada denda.'));
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();
        return redirect()->route('admin.pengembalian.index')->with('success', 'Data pengembalian dihapus.');
    }
}
