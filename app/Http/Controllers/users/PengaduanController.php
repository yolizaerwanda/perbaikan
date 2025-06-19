<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\PengaduanStoreRequest;
use App\Http\Requests\users\PengaduanUpdateRequest;
use App\Models\CategoryReport;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengaduans = Pengaduan::with('kategori')
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->get();
        return view('users.pengaduan.index', compact('pengaduans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $pengaduans = CategoryReport::all();
        return view('users.pengaduan.create', compact('pengaduans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengaduanStoreRequest $request)
    {
        // dd($request->all());
        $pengaduan = new Pengaduan();
        $pengaduan->user_id = auth()->user()->id;
        $pengaduan->kategori_id = $request->kategori_id;
        $pengaduan->judul = $request->judul;
        $pengaduan->isi_pengaduan = $request->isi_pengaduan;
        $pengaduan->status = 'menunggu';
        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        $pengaduans = CategoryReport::all();
        return view('users.pengaduan.edit', compact('pengaduan', 'pengaduans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengaduanUpdateRequest $request, Pengaduan $pengaduan)
    {
        $pengaduan->user_id = auth()->user()->id;
        $pengaduan->kategori_id = $request->kategori_id;
        $pengaduan->judul = $request->judul;
        $pengaduan->isi_pengaduan = $request->isi_pengaduan;
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->FindOrFail($pengaduan->id);
        if ($pengaduan->status == 'proses') {
            return redirect()->route('pengaduan.index')->with('error', 'Pengaduan tidak dapat dihapus karena sedang dalam proses.');
        }
        if ($pengaduan->status == 'selesai') {
            return redirect()->route('pengaduan.index')->with('error', 'Pengaduan tidak dapat dihapus karena sudah selesai.');
        }
        // if ($pengaduan->status == 'ditolak') {
        //     return redirect()->route('pengaduan.index')->with('error', 'Pengaduan tidak dapat dihapus karena sudah ditolak.');
        // }
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
