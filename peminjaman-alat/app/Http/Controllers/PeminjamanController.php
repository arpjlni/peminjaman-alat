<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Admin: CRUD semua peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->paginate(10);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $alats = Alat::where('status', 'tersedia')->where('kondisi', 'baik')->get();
        return view('admin.peminjaman.create', compact('alats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'alat_id'    => 'required|exists:alat,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali'=> 'required|date|after:tgl_pinjam',
        ]);

        Peminjaman::create($request->only(['user_id', 'alat_id', 'tgl_pinjam', 'tgl_kembali']));
        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman ditambahkan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $alats = Alat::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'alats'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'status_peminjaman' => 'required|in:menunggu,disetujui,ditolak,dikembalikan',
        ]);
        $peminjaman->update($request->only(['status_peminjaman']));
        return redirect()->route('admin.peminjaman.index')->with('success', 'Status peminjaman diupdate.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }

    // Peminjam: ajukan peminjaman
    public function ajukan()
    {
        $alats = Alat::with('kategori')->where('status', 'tersedia')->where('kondisi', 'baik')->get();
        return view('peminjam.ajukan', compact('alats'));
    }

    public function simpanAjuan(Request $request)
    {
        $request->validate([
            'alat_id'    => 'required|exists:alat,id',
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'tgl_kembali'=> 'required|date|after:tgl_pinjam',
        ]);

        $alat = Alat::findOrFail($request->alat_id);
        if ($alat->status !== 'tersedia') {
            return back()->withErrors(['alat_id' => 'Alat tidak tersedia.']);
        }

        Peminjaman::create([
            'user_id'    => auth()->id(),
            'alat_id'    => $request->alat_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali'=> $request->tgl_kembali,
            'status_peminjaman' => 'menunggu',
        ]);

        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => 'Mengajukan peminjaman alat: ' . $alat->nama_alat,
            'waktu'     => now(),
        ]);

        return redirect()->route('peminjam.riwayat')->with('success', 'Peminjaman berhasil diajukan, menunggu persetujuan.');
    }

    // Peminjam: riwayat peminjaman
    public function riwayat()
    {
        $peminjamans = Peminjaman::with(['alat', 'pengembalian'])
            ->where('user_id', auth()->id())
            ->latest()->paginate(10);
        return view('peminjam.riwayat', compact('peminjamans'));
    }

    // Petugas: setujui/tolak peminjaman
    public function daftarPersetujuan()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status_peminjaman', 'menunggu')
            ->latest()->paginate(10);
        return view('petugas.persetujuan', compact('peminjamans'));
    }

    public function setujui(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status_peminjaman' => 'disetujui']);
        $peminjaman->alat->update(['status' => 'dipinjam']);

        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => 'Menyetujui peminjaman ID: ' . $peminjaman->id,
            'waktu'     => now(),
        ]);

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function tolak(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status_peminjaman' => 'ditolak']);

        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => 'Menolak peminjaman ID: ' . $peminjaman->id,
            'waktu'     => now(),
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }
}
