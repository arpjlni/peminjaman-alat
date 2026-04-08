<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->latest()->paginate(10);
        return view('admin.alat.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'   => 'required',
            'kategori_id' => 'required|exists:kategori,id',
            'kondisi'     => 'required|in:baik,rusak,perbaikan',
            'jumlah'      => 'required|integer|min:1',
        ]);

        Alat::create($request->only(['nama_alat', 'kategori_id', 'kondisi', 'jumlah']));
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat'   => 'required',
            'kategori_id' => 'required|exists:kategori,id',
            'kondisi'     => 'required|in:baik,rusak,perbaikan',
            'status'      => 'required|in:tersedia,dipinjam',
            'jumlah'      => 'required|integer|min:1',
        ]);

        $alat->update($request->only(['nama_alat', 'kategori_id', 'kondisi', 'status', 'jumlah']));
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diupdate.');
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }

    // Untuk peminjam: lihat daftar alat tersedia
    public function daftarAlat()
    {
        $alats = Alat::with('kategori')->where('status', 'tersedia')->where('kondisi', 'baik')->paginate(10);
        return view('peminjam.alat', compact('alats'));
    }
}
