<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Beasiswa::query()->where('status', 'buka');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_program', 'like', "%{$search}%")
                  ->orWhere('penyelenggara', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $beasiswas = $query->orderBy('tgl_tutup', 'asc')->get();

        return view('landing', compact('beasiswas'));
    }

    public function show(Beasiswa $beasiswa): View
    {
        $beasiswa->load('kriteria');
        return view('beasiswa.detail', compact('beasiswa'));
    }
}
