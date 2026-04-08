<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')->orderByDesc('waktu')->paginate(20);
        return view('admin.log.index', compact('logs'));
    }
}
