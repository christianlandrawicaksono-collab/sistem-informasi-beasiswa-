@extends('layouts.app')

@section('title', 'Daftar Program Beasiswa')

@section('content')
<div data-motion="hero-item" class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#5B6573] hover:text-[#FF7448] transition mb-2">
            <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            <span>Dashboard Admin</span>
        </a>
        <h1 class="text-2xl font-extrabold text-[#0F151D]">Kelola Program Beasiswa</h1>
        <p class="text-xs text-[#5B6573] mt-0.5">Daftar seluruh program beasiswa beserta kuota dan jumlah pelamar aktif.</p>
    </div>

    <a href="{{ route('admin.beasiswa.create') }}" data-motion="pill-press" class="nomu-cta-btn px-5 py-2.5 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shrink-0">
        <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        <span>Tambah Beasiswa</span>
    </a>
</div>

<div data-motion="reveal" class="nomu-panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-[#FFF9F6] text-[11px] font-mono uppercase tracking-wider text-[#5B6573] border-b border-[#0F151D]/8">
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
            <tbody data-motion="table-stagger" class="divide-y divide-[#0F151D]/6">
                @foreach($beasiswas as $b)
                    <tr class="hover:bg-[#FFF9F6]/60 transition">
                        <td class="px-6 py-4 font-bold text-[#0F151D]">{{ $b->nama_program }}</td>
                        <td class="px-6 py-4 text-xs text-[#0F151D]">{{ $b->kategori }}</td>
                        <td class="px-6 py-4 text-xs text-[#5B6573]">{{ $b->penyelenggara }}</td>
                        <td class="px-6 py-4 text-center font-mono font-bold tabular-nums">{{ $b->kuota }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full bg-[#E4EDFF] text-[#243C61] text-xs font-bold tabular-nums">
                                {{ $b->pengajuan_count }} Pelamar
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono tabular-nums">{{ $b->tgl_tutup->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-[11px] font-bold px-3 py-1 rounded-full uppercase {{ $b->status === 'buka' ? 'bg-[#E5F3EE] text-[#237C65]' : 'bg-[#F1EBE9] text-[#5B6573]' }}">
                                {{ $b->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
