<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\TanggapanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TanggapanPengaduanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil tanggapan berdasarkan user yg sedang login
        $tanggapans = TanggapanPengaduan::whereHas('pengaduan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('pengaduan')->latest()->get();

        return view('users.tanggapanpengaduan.index', compact('tanggapans'));
    }
}
