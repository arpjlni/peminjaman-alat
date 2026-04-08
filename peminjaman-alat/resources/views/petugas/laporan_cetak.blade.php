<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Alat</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body { padding: 20px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
<div class="text-center" style="margin-bottom:20px;">
    <h3>Laporan Peminjaman Alat</h3>
    <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="no-print" style="margin-bottom:15px;">
    <button onclick="window.print()" class="btn btn-primary">
        <span class="glyphicon glyphicon-print"></span> Print
    </button>
    <button onclick="window.close()" class="btn btn-default">Tutup</button>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Denda</th></tr>
    </thead>
    <tbody>
    @foreach($peminjamans as $i => $p)
    <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $p->user->nama }}</td>
        <td>{{ $p->alat->nama_alat }}</td>
        <td>{{ $p->tgl_pinjam->format('d/m/Y') }}</td>
        <td>{{ $p->tgl_kembali->format('d/m/Y') }}</td>
        <td>{{ ucfirst($p->status_peminjaman) }}</td>
        <td>{{ $p->pengembalian && $p->pengembalian->denda > 0 ? 'Rp ' . number_format($p->pengembalian->denda, 0, ',', '.') : '-' }}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr><td colspan="6" class="text-right"><strong>Total Denda:</strong></td><td><strong>Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong></td></tr>
    </tfoot>
</table>
</body>
</html>
