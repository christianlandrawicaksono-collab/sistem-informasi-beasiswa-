@extends('layouts.app')

@section('title', 'Kelola Program Beasiswa')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Daftar Program Beasiswa</h1>
        <p class="text-xs text-slate-500">Kelola periode aktif, kuota penerima, dan kriteria penilaian SPK.</p>
    </div>
    <a href="{{ route('admin.beasiswa.create') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center space-x-1.5">
        <i class="fa-solid fa-plus"></i>
        <span>Tambah Beasiswa</span>
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3.5">Nama Program</th>
                <th class="px-6 py-3.5">Kategori</th>
                <th class="px-6 py-3.5">Penyelenggara</th>
                <th class="px-6 py-3.5 text-center">Kuota</th>
                <th class="px-6 py-3.5 text-center">Pendaftar</th>
                <th class="px-6 py-3.5">Batas Waktu</th>
                <th class="px-6 py-3.5 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
            @foreach($beasiswas as $b)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4 font-bold text-slate-900">
                        {{ $b->nama_program }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $b->kategori }}
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-500">
                        {{ $b->penyelenggara }}
                    </td>
                    <td class="px-6 py-4 text-center font-bold">
                        {{ $b->kuota }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                            {{ $b->pengajuan_count }} Pelamar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $b->tgl_tutup->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full uppercase {{ $b->status === 'buka' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $b->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
